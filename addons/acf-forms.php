<?php  namespace TPF;

class ACF_Forms {

  public function __construct($init = false) {
    
    if($init) {

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
      include(__DIR__ . "/../functions/acf-form-submit.php");
      add_action('after_setup_theme', 'acf_form_submit');

    }

  }

  public function render($id, $args = []) {

    if (!the_project('forms')) {
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
        "value" => home_url( $wp->request ),
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
    foreach($form_fields as $field) {

      $name = isset($field['name']) && !empty($field['name']) ? $field['name'] : false;
      if(!$name) {
        $name = sanitize_key($field['label']);
      }

      $arr = [];
      if($field['acf_fc_layout'] == 'select' || $field['acf_fc_layout'] == "radio" || $field['acf_fc_layout'] == "checkbox") {
        $options = explode(PHP_EOL, $field['options']);
        foreach($options as $opt) {
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
    $new_form->render();

  }

}