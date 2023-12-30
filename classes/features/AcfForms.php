<?php

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class ACF_Forms {

  public $post_type_data;

  public function __construct($init = false) {

    if (is_admin()) {
      add_filter('acf/fields/flexible_content/layout_title/name=form_fields', [$this, 'flexible_field_labels'], 10, 4);
    }

    if ($init) {

      $this->post_type_data = [
        'name' => "project-forms",
        "title" => 'Forms',
        "singular_name" => "Form",
        "icon" => "dashicons-feedback",
        "menu_position" => 5,
        "submenu_title" => "Forms",
        "show_in_menu" => 'site-settings',
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
        TPF_ACF_Group_Init('form');
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
  //  Flexible Field
  //--------------------------------------------------------

  /**
   * Set layout labels based on the title or headline fields
   */
  public function flexible_field_labels($title, $field, $layout, $i) {

    $subfield = !empty(get_sub_field('label')) ? get_sub_field('label') : get_sub_field('name');
    $required = !empty(get_sub_field('required')) ? "<span style='color: red;'>*</span>" : "";
    $width = get_sub_field('width');

    switch ($width) {
      case '2-3':
        $width = "70%";
        break;
      case '3-5':
        $width = "60%";
        break;
      case '1-2':
        $width = "50%";
        break;
      case '2-5':
        $width = "40%";
        break;
      case '1-3':
        $width = "30%";
        break;
      case '1-4':
        $width = "25%";
        break;
      case '1-5':
        $width = "20%";
        break;
    }

    $width = $width != "1-1" ? " - <span style='color: #555; font-weight: 400;'>{$width}</span>" : "";

    if ($subfield) $title = $title . $width . " - " . $subfield . " $required";

    return "<span title='hello'>$title</span>";
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
        "body" => !empty($field['body']) ? $field['body'] : "",
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
