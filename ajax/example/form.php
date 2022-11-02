<?php

$util = new TPF_Utility();

//
//  Default Reponse
//

$response = [
  "status" => "success", // used also for notification color
  "reset_form" => false, // clear-reset form input values
  // "notification" => "Notification: Ajax form submit was ok!", // if no modal, notification will be used
  // "modal" => "<h3>Modal Response</h3><p>Ajax form submit was successful</p>", // modal has priority
  //"redirect" => "/", // if used with modal, will redirect after modal confirm... 
  "errors" => [], // array of errors (strings), will trigger notification for each
  "error_fields" => [], // array of names for invalid fields
  "post" => $_POST,
];

//
//  Process Form
//

if($_POST['test_form']) {
  
  if( !wp_verify_nonce($_POST['nonce'], "ajax-nonce") ) exit();

  //-------------------------------------------------------- 
  //  Validate
  //-------------------------------------------------------- 
  
  $v = $util->valitorn($_POST);
  $v->rule('required', ['name', 'email', 'message']); 
  $v->rule('email', 'email');

  $v->labels([
    'name' => 'Name',
    'email' => 'Email',
    'message' => 'Message'
  ]);

  if(!$v->validate()) {

    // get errors from valitron and store them in errors array
    $errors = [];
    $errors_fields = [];
    foreach($v->errors() as $key => $value) {
      $errors[] = $value[0]; 
      $errors_fields[] = $key;
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
  //  If valid continue...
  //-------------------------------------------------------- 

  // Admin email
  $admin_email = get_option('admin_email');

  // Email headers
  $headers = [];
  $headers[] = 'Content-Type: text/html; charset=UTF-8';
  $headers[] = "From: Website <{$admin_email}>";
  $headers[] = "Reply-to: {$_POST['email']}";

  // Email to who?
  $send_to =  $admin_email;

  // Subject
  $subject = "Email from {$_POST['name']}";
  
  // Message
  $message = "";

  foreach($_POST as $key => $value) {
    $message .= "<strong>{$key}</strong>: {$value}<br />";
  }

  try {

    if( wp_mail($sent_to, $subject, $message, $headers) ) {

      $response["status"] = "success";
      $response["modal"] = "<h3>Thank you!</h3><p>Your message has been sent. Thank you for your time!</p>";

    } else {

      $response["danger"] = "danger";
      $response["modal"] = "<h3 class='uk-text-danger'>Error</h3><p>There was an error, please try again</p>";

    }

  } catch (Exception $e) {

    $response["danger"] = "danger";
    $response["modal"] = "<h3 class='uk-text-danger'>Error!</h3><p>{$e->getMessage()}</p>";

  }

}

//-------------------------------------------------------- 
//  Set JSON Header and Reponse
//-------------------------------------------------------- 

header('Content-type: application/json');
echo json_encode($response);

exit();