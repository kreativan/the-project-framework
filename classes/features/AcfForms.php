<?php

namespace TPF;

class ACF_Forms {

  public function __construct($init = false) {

    if ($init) {

      $this->post_type_data = [
        'name' => "project-forms",
        "title" => 'Forms',
        "singular_name" => "Form",
        "icon" => "dashicons-feedback",
        "menu_position" => 5,
        "submenu_title" => "Forms",
        "admin_columns" => [
          'id' => 'ID',
        ],
      ];

      new Post_Type($this->post_type_data);
      add_action('after_setup_theme', 'acf_form_submit');

      /**
       * Protected Forms
       */
      add_action('pre_trash_post', [$this, 'no_delete'], 10, 1);
      add_filter('bulk_actions-edit-project-forms', [$this, 'remove_bulk_actions']);
      add_filter('page_row_actions', [$this, 'remove_quick_actions'], 10, 2);

      // add custom meta box
      add_action('add_meta_boxes', [$this, 'metaboxes']);

      // ACF field group
      if (function_exists('acf_add_local_field_group')) {
        tpf_acf_group_init('form');
      }

      /**
       * Shortcode
       * [tpf_form id=123]
       */
      add_shortcode('tpf_form', function ($attr) {
        ob_start();
        $id = $attr['id'];
        if (!empty($id)) {
          $acf_form = new ACF_Forms();
          $acf_form->render($id);
        }
        $content = ob_get_clean();
        return $content;
      });
    }
  }

  public function protected_forms() {
    $protected_forms = the_project('protected_forms');
    $protected_forms_array = explode(',', $protected_forms);
    return $protected_forms_array;
  }

  public function is_protected($post) {
    return in_array($post->ID, $this->protected_forms()) ? true : false;
  }

  //-------------------------------------------------------- 
  //  Hooks
  //-------------------------------------------------------- 

  public function no_delete($post) {
    $admin_url = admin_url('edit.php?post_type=project-forms');
    global $post;
    if ($post->post_type == 'project-forms' && $this->is_protected($post)) {
      wp_redirect($admin_url);
      exit();
    }
  }

  public function remove_bulk_actions($actions) {
    unset($actions['trash']);
    return $actions;
  }

  public function remove_quick_actions($actions, $post) {
    if ($post->post_type == 'project-forms' && $this->is_protected($post)) {
      unset($actions['trash']);
    }
    return $actions;
  }

  //-------------------------------------------------------- 
  //  Metabox
  //-------------------------------------------------------- 

  public function metaboxes() {
    add_meta_box(
      'acf-forms-meta-box', // id, used as the html id att
      __('Form'), // meta box title, like "Page Attributes"
      [$this, 'meta_box_content'], // callback function, spits out the content
      'project-forms', // post type or page. We'll add this to pages only
      'side', // context (where on the screen
      'low' // priority, where should this go in the context?
    );
  }

  public function meta_box_content($post) {
    $form_fields = get_field('form_fields', $post);
    echo "<p class='p-margin-top'><b>Shortcode:</b></p>";
    echo "<div><code>[tpf_form id={$post->ID}]</code></div>";
    echo "<p><b>Fields:</b></p>";
    echo "<ul class='p-list p-list-striped'>";
    echo "<li>Page (hidden) : page</li>";
    if ($form_fields) {
      foreach ($form_fields as $item) {
        $required = !empty($item['required']) ? "<span style='color: red;'>*</span>" : "";
        echo "<li>{$item['label']} {$required} : {$item['name']}</li>";
      }
    }
    echo "</ul>";
    if (get_field('send_email', $post)) {
      echo "<div class='p-margin-top'><b>Email to:</b></div>";
      echo "<div>" . get_field('admin_email', $post) . "</div>";
    }
    if (get_field('create_post', $post)) {
      echo "<div class='p-margin-top'><b>Create post type:</b></div>";
      echo "<div>" . get_field('select_post_type', $post) . "</div>";
    }
  }

  //-------------------------------------------------------- 
  //  Render
  //-------------------------------------------------------- 

  public function render($id, $args = []) {

    if (!tpf_settings('forms')) {
      echo "<div class='uk-text-danger'>The Project forms are disabled</div>";
      return false;
    }

    $args['id'] = $id;

    $acf_form = get_post($id);

    $button_style = !empty($args['button_style']) ? $args['button_style'] : 'primary';
    $labels = get_field('labels', $id);
    $grid_size = get_field('grid_size', $id);
    $form_fields = get_field('form_fields', $id);
    $action = get_field('action_url', $id);
    $action = !empty($action) ? $action : "./";
    $captcha = get_field('captcha', $id);

    global $wp;

    // Default hidden fields
    $fields = [
      "page" => [
        "type" => "hidden",
        "name" => "page",
        "value" => home_url($wp->request),
      ],
      "nonce" => [
        "type" => "hidden",
        "name" => "nonce",
        "value" => wp_create_nonce('acf-ajax-nonce'),
      ],
      "form_id" => [
        "type" => "hidden",
        "name" => "form_id",
        "value" => $id,
      ],
      "the_project_acf_form" => [
        "type" => "hidden",
        "name" => "the_project_acf_form",
        "value" => $id,
      ],
    ];


    // Create fields array
    foreach ($form_fields as $field) {

      $name = isset($field['name']) && !empty($field['name']) ? $field['name'] : false;
      if (!$name) {
        $name = sanitize_key($field['label']);
      }

      $arr = [];
      if ($field['acf_fc_layout'] == 'select' || $field['acf_fc_layout'] == "radio" || $field['acf_fc_layout'] == "checkbox") {
        $options = explode(PHP_EOL, $field['options']);
        foreach ($options as $opt) {
          $i = explode('=', $opt);
          $arr[$i[0]] = $i[1];
        }
      }

      $fields[] = [
        "type" => $field['acf_fc_layout'],
        "name" => $name,
        "label" => $field['label'],
        "placeholder" => ($labels == "2" || $labels == "3") ? $field['placeholder'] : "",
        "grid" => $field['width'],
        "options" => $arr,
        "description" => $field['description'],
        "req" => $field['required'] == "1" ? true : false,
        "rows" => !empty($field['rows']) ? $field['rows'] : "",
      ];
    }

    // create form
    $new_form = new Form();
    $new_form->fields = $fields;
    $new_form->action = $action;
    $new_form->id = "form-{$acf_form->ID}";
    $new_form->ajax = true;
    $new_form->numb_captcha = $captcha == 1 ? true : false;
    $new_form->labels = ($labels == "1" || $labels == "3") ? true : false;
    $new_form->grid_size = $grid_size;
    $new_form->button_text = get_field('submit_button_text', $acf_form->ID);
    $new_form->render();
  }
}
