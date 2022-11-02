<?php

function acf_form_submit() {

  $util = new TPF_Utility();

  if (!isset($_POST)) return;
  if (!isset($_POST['nonce'])) return;
  if (!isset($_POST['form_id'])) return;
  if (!isset($_POST['the_project_acf_form'])) return;


  //
  //  Default Reponse
  //

  $response = [
    "status" => "none", // used also for notification color
    "reset_form" => false, // clear-reset form input values
    // "notification" => "Notification: Ajax form submit was ok!", // if no modal, notification will be used
    // "modal" => "<h3>Modal Response</h3><p>Ajax form submit was successful</p>", // modal has priority
    //"redirect" => "/", // if used with modal, will redirect after modal confirm... 
    "errors" => [], // array of errors (strings), will trigger notification for each
    "error_fields" => [], // array of names for invalid fields
    "post" => $_POST,
    "SMTP" => the_project('smtp_enable'),
  ];

  //
  //  Process Form
  //

  if (!empty($_POST['form_id'])) {

    if( !wp_verify_nonce($_POST['nonce'], "acf-ajax-nonce") ) exit();

    $form_id = sanitize_text_field($_POST['form_id']);
    $form_fields = get_field('form_fields', $form_id);
    $files_count = count($_FILES);

    // captcha
    $is_captcha = get_field('captcha', $form_id);
    $captcha = true;
    
    if($is_captcha) {
      $q1 = $_POST['q1'];
      $q2 = $_POST['q2'];
      $answ = $_POST['answ'];
      $sum = $q1 + $q2;
      $captcha = ($answ == $sum) ? true : false;
    }
    
    $req_array = [];
    $email_array = [];
    $labels_array = [];
    $files_array = [];

    if(!$captcha) $req_array[] = 'answ';

    foreach($form_fields as $f) {
      $labels_array[$f['name']] = $f['label'];
      if($f['required'] && $f['acf_fc_layout'] != 'file') $req_array[] = $f['name'];
      if($f['acf_fc_layout'] == 'email') $email_array[] = $f['name'];
      if($f['acf_fc_layout'] == 'file') $files_array[] = $f;
    }

    // Is there any required files ?
    $is_files = count($files_array) > 0 ? true : false;
    if($is_files) {
      $req_files = [];
      foreach($files_array as $f) {
        $key = $f['name'];
        $value = $f['label'];
        if($f['required']) $req_files[$key] = $value;
      }
      $req_files_count = count($req_files);
      $is_files = count($req_files) > 0 ? true : false;
    }


    //-------------------------------------------------------- 
    //  Validate
    //-------------------------------------------------------- 
    
    $v = $util->valitron($_POST);
    $v->rule('required', $req_array); 
    $v->rule('email', $email_array);
    $v->labels($labels_array);

    $files_errors = ($is_files && ($files_count < $req_files_count)) ? true : false;
    
    if(!$v->validate() || $files_errors || !$captcha) {

      // get errors from valitron and store them in errors array
      $errors = [];
      $errors_fields = [];
      foreach($v->errors() as $key => $value) {
        if($key != "answ") $errors[] = $value[0]; 
        $errors_fields[] = $key;
      }

      //if(!$captcha) $errors[] = lng('Wrong Captcha');

      // trigger files errors
      if($files_errors) {
        foreach($req_files as $e) {
          $errors[] = "{$e} is required";
        }
      }
      
      $response["status"] = "error";
      $response["errors"] = $errors;
      $response["reset_form"] = false;
      $response["error_fields"] = $errors_fields;

      header('Content-type: application/json');
      echo json_encode($response);
      exit();

    }

    //-------------------------------------------------------- 
    //  Validation pass, continue...
    //-------------------------------------------------------- 

    // We will store files and fields values here
    $post_files = [];
    $post_fields = [];

    // create post or no?
    $create_post = get_field('create_post', $form_id);
    $post_type_name = get_field('post_type_name', $form_id);
    if(empty($post_type_name) && !post_type_exists($post_type_name)) $create_post = false;

    //  Upload Files - $post_files
    // ===========================================================
    if($is_files) {
      // These files need to be included as dependencies when on the front end.
      require_once( ABSPATH . 'wp-admin/includes/image.php' );
      require_once( ABSPATH . 'wp-admin/includes/file.php' );
      require_once( ABSPATH . 'wp-admin/includes/media.php' );

      // Let WordPress handle the upload.
      foreach($files_array as $file) {
        $name = $file['name'];
        $post_files[$name] = media_handle_upload($name, 0);
      }
    }

    //  Fields - $post_fields
    // ===========================================================

    // get non-empty fields and store them to post_fields
    foreach($form_fields as $f) {
      if($f['acf_fc_layout'] != 'file') {
        $name = $f['name'];
        $value = $_POST[$name];
        if(!empty($value)) {
          $post_fields[$name] = sanitize_text_field($value);
        }
      }
    }

    // Create a Post
    // ===========================================================

    $allow_post = $create_post ? true : false;
    $allow_duplicated_posts = get_field('allow_duplicated_posts', $form_id);
    $field_name_to_validate = get_field('field_name_to_validate', $form_id);

    // handle duplicated posts
    if($create_post && !$allow_duplicated_posts) {

      $post = get_posts([
        'numberposts'	=> 1,
        'post_type'		=> $post_type_name,
        'meta_key'		=> $field_name_to_validate,
        'meta_value'	=> $_POST[$field_name_to_validate],
      ]);

      if($post) {

        $allow_post = false;

        $duplicate_message = get_field('duplicate_message', $form_id);
        $duplicate_msg = tpf_str_replace($duplicate_message, $_POST);
        
        $response["status"] = "warning";
        $response['modal'] =  $duplicate_msg;
        $response["reset_form"] = true;

        header('Content-type: application/json');
        echo json_encode($response);
        exit();

      }

    }

    // Create Post
    if($create_post && $allow_post) {

      $post_title = get_field('new_post_title', $form_id);
      $post_title = tpf_str_replace($post_title, $_POST);
      $post_title = !empty($post_title) ? $post_title : $post_type_name;

      $meta_input = [];

      if(count($post_fields) > 0) {
        foreach($post_fields as $key => $value) $meta_input[$key] = $value;
      }

      if(count($post_files) > 0) {
        foreach($post_files as $key => $value) $meta_input[$key] = $value;
      }

      $new_post = [
        'post_type' => $post_type_name,
        'post_title' => $post_title,
        'post_status' => 'publish',
        'meta_input' => $meta_input,
      ];

      wp_insert_post($new_post);

    }

    //  Email
    // ===========================================================

    $send_email = get_field('send_email', $form_id);

    if($send_email) {

      // Admin email
      $admin_email = get_field('admin_email', $form_id);
      $site_email = get_field('site_email', 'options');
      $send_to = !empty($admin_email) ? $admin_email : $site_email;
      // from
      $mail_from_arr = explode(",", $send_to);
      $mail_from = count($mail_from_arr) ? $mail_from_arr[0] : $send_to;

      // Subject
      $subject = get_field('subject', $form_id);
      $subject = tpf_str_replace($subject, $_POST);
      $subject = !empty($subject) ? $subject : "Website form submition";

      // reply to
      $reply_to = $_POST['email'];
      foreach($form_fields as $f) {
        if($f['acf_fc_layout'] == 'email') {
          $name = $f['name'];
          if(!empty($_POST[$name])) $reply_to = sanitize_text_field($_POST[$name]);
          break;
        }
      }

      // Email headers
      $headers = [];
      $headers[] = 'Content-Type: text/html; charset=UTF-8';
      if(the_project('smtp_enable') != '1') {
        $headers[] = "From: Website <{$mail_from}>";
      }
      $headers[] = "Reply-to: $reply_to";

      // Message
      $message = "";
      $exclude_vars = ['nonce', 'form_id'];
      foreach($_POST as $key => $value) {
        if(!in_array($key, $exclude_vars) && !empty($value)) {
          $message .= "<p><strong>{$key}</strong><br />{$value}</p>";
        }
      }

      // attachments
      $attachments = [];
      if(count($post_files) > 0) {
        foreach($post_files as $file_id) {
          $attachments[] = wp_get_attachment_url($file_id);
        }
      }

      // Send Mail
      try {

        wp_mail($send_to, $subject, $message, $headers, $attachments);

      } catch (Exception $e) {

        $response["email_error"] = $e->getMessage();

      }


    }

    //  Response
    // ===========================================================
    $title = get_field('success_title', $form_id);
    $title = tpf_str_replace($title, $_POST);
    $text = get_field('success_message', $form_id);
    $text = tpf_str_replace($text, $_POST);
    $response_text = !empty($title) ? "<h3>$title</h3>" : '';
    $response_text .= !empty($text) ? "<p>$text</p>" : '';
    $response["modal"] =  $response_text;
    $response["status"] = 'success';
    $response["reset_form"] = true;

  }


  header('Content-type: application/json');
  echo json_encode($response);

  exit();

}