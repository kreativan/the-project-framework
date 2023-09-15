<?php

/**
 * Custom Fields
 * Use this as a blueprint to create custom fields
 * @method custom_fields() Define your custom fields here
 * @method check() Check if product should have custom fields
 * @var array $project_custom_fields - If you pass array to the constructor, it will override custom_fields() function
 * 
 * Available field types
 * @see https://rudrastyh.com/woocommerce/woocommerce_form_field.html
 */

namespace TPF;

class CustomFieldsBlueprint {

  public function __construct($project_custom_fields = []) {
    // Register the file field on the product page
    add_action('woocommerce_before_add_to_cart_button', [$this, 'register_custom_field']);
    // Save the custom field value
    add_action('woocommerce_add_cart_item_data', [$this, 'save_custom_field'], 10, 2);
    // Display the custom field on cart and checkout
    add_filter('woocommerce_get_item_data', [$this, 'display_custom_field'], 10, 2);
    //  Display the custom field on order
    add_action('woocommerce_order_item_meta_end', [$this, 'display_custom_field_on_order'], 10, 4);
    // Validate the custom field before adding to cart
    add_filter('woocommerce_add_to_cart_validation', [$this, 'validate_custom_field'], 10, 3);
  }

  /**
   * Define your custom fields here
   * If you pass $project_custom_fields array to the constructor, it will override this function
   * @return array
   */
  public function custom_fields($product_id) {

    // Use passed array if it's not empty
    if (count($this->project_custom_fields) > 0) return $this->project_custom_fields;

    // Custom fields array
    $array = [];

    // Example field
    $array[] = [
      "type" => "text", // text, file
      "name" => "custom_field_1",
      "label" => "Custom Field 1",
      "placeholder" => "Custom Field 1",
      "required" => true,
      "description" => "Custom Field 1",
      "options" => [],
      "default" => "",
    ];

    return $array;
  }

  /**
   * Check if product should have custom fields
   * @return bool
   */
  public function check($product_id) {
    $custom_fields = $this->custom_fields($product_id);
    if (empty($custom_fields)) return false;
    return true;
  }

  // --------------------------------------------------------- 
  // Register
  // --------------------------------------------------------- 

  public function register_custom_field() {

    global $product;

    // Get product id
    $product_id = $product->get_id();

    // Check if this product should have custom fields
    if (!$this->check($product_id)) return;

    // Get custom fields
    $custom_fields = $this->custom_fields($product_id);

    foreach ($custom_fields as $custom_field) {

      $type = !empty($custom_field['type']) ? $custom_field['type'] : 'text';
      $name = !empty($custom_field['name']) ? $custom_field['name'] : '';
      $label = !empty($custom_field['label']) ? $custom_field['label'] : $name;

      $placeholder = !empty($custom_field['placeholder']) ? $custom_field['placeholder'] : '';
      $required = !empty($custom_field['required']) ? $custom_field['required'] : false;
      $description = !empty($custom_field['description']) ? $custom_field['description'] : '';
      $options = !empty($custom_field['options']) ? $custom_field['options'] : [];
      $default = !empty($custom_field['default']) ? $custom_field['default'] : '';

      echo "<div class='woo-custom-field uk-margin-small'>";

      if ($type == "file") {

        $required = $required ? 'required' : '';
        $placeholder = !empty($placeholder) ? $placeholder : 'Select file';
        echo "<div class='form-row'>";
        echo "<label class='uk-form-label uk-display-block' for='$label' style='margin-bottom: 3px;'>";
        echo $label;
        if ($required != "") echo "<span class='required' title='required'>*</span>";
        echo "</label>";
        echo '<div class="uk-form-custom" uk-form-custom="target: true">';
        echo "<input type='file' name='$name' accept='image/*,.pdf' />";
        echo "<input class='uk-input uk-form-width-medium' type='text' placeholder='$placeholder' disabled />";
        echo '</div>';
        echo '</div>';
      } else {

        $value = $product->get_meta("$name");
        $value = !empty($value) ? $value : $default;

        woocommerce_form_field($name, array(
          'type'          => $type,
          'class'         => array("woo-custom-field-{$name} form-row-wide"),
          'label'         => $label,
          'placeholder'   => $placeholder,
          'required'      => $required,
          'description'   => $description,
          'options'       => $options, // ['val => 'label']
          'default'       => $default,
        ), $value);
      }

      echo '</div>';
    }
  }

  // --------------------------------------------------------- 
  // Save
  // ---------------------------------------------------------

  public function save_custom_field($cart_item_data, $product_id) {

    // Check if this product should have custom fields
    if (!$this->check($product_id)) return $cart_item_data;

    // Get custom fields
    $custom_fields = $this->custom_fields($product_id);

    foreach ($custom_fields as $custom_field) {

      $type = !empty($custom_field['type']) ? $custom_field['type'] : 'text';
      $name = !empty($custom_field['name']) ? $custom_field['name'] : '';
      $label = !empty($custom_field['label']) ? $custom_field['label'] : $name;

      if ($type == "file") {
        if (!empty($_FILES[$name]['name'])) {
          $upload = wp_upload_bits($_FILES[$name]['name'], null, file_get_contents($_FILES[$name]['tmp_name']));
          if (isset($upload['error']) && $upload['error'] != 0) {
            wc_add_notice(__('There was an error uploading the file. Please try again.', 'woocommerce'), 'error');
          } else {
            $cart_item_data[$name] = $upload;
          }
        }
      } else {
        if (isset($_POST[$name])) {
          $cart_item_data[$name] = sanitize_text_field($_POST[$name]);
        }
      }
    }

    return $cart_item_data;
  }

  // --------------------------------------------------------- 
  // Display on cart, checkout
  // --------------------------------------------------------- 

  public function display_custom_field($item_data, $cart_item) {

    // Get product id
    $product_id = $cart_item['product_id'];

    // Check if this product should have custom fields
    if (!$this->check($product_id)) return $item_data;

    // Get custom fields
    $custom_fields = $this->custom_fields;

    foreach ($custom_fields as $custom_field) {

      $type = !empty($custom_field['type']) ? $custom_field['type'] : 'text';
      $name = !empty($custom_field['name']) ? $custom_field['name'] : '';
      $label = !empty($custom_field['label']) ? $custom_field['label'] : $name;

      if ($type == "file") {
        if (isset($cart_item[$name])) {
          $file_name = basename($cart_item[$name]['file']);
          $item_data[] = array(
            'key'     => __($label, 'woocommerce'),
            'value'   => '<a href="' . esc_url($cart_item[$name]['url']) . '" target="_blank">' . $file_name . '</a>',
          );
        }
      } else {
        if (isset($cart_item[$name])) {
          $item_data[] = array(
            'key'     => $label,
            'value'   => wc_clean($cart_item[$name]),
          );
        }
      }
    }

    return $item_data;
  }

  // --------------------------------------------------------- 
  // Display on order
  // --------------------------------------------------------- 

  // Display the custom field on order
  public function display_custom_field_on_order($item, $cart_item_key, $values, $order) {

    $product_id = $item->get_product_id();
    $custom_fields = $this->custom_fields;
    $check = $this->check($product_id);

    if ($check) {
      foreach ($custom_fields as $custom_field) {

        $type = !empty($custom_field['type']) ? $custom_field['type'] : 'text';
        $name = !empty($custom_field['name']) ? $custom_field['name'] : '';
        $label = !empty($custom_field['label']) ? $custom_field['label'] : $name;

        if ($type == "file") {
          $file_field = isset($values[$name]) ? $values[$name] : '';
          if ($file_field) {
            $file_name = basename($file_field['file']);
            echo '<br><strong>' . __($label) . ':</strong> <a href="' . esc_url($file_field['url']) . '" target="_blank">' . $file_name . '</a>';
          }
        } else {
          $value = isset($values[$name]) ? $values[$name] : '';
          if (!empty($value)) $item->add_meta_data($this->label, $value);
        }
      }
    }
  }

  // --------------------------------------------------------- 
  // Validate
  // --------------------------------------------------------- 

  public function validate_custom_field($passed, $product_id, $quantity) {

    $check = $this->check($product_id);

    if ($check) {

      $custom_fields = $this->custom_fields($product_id);

      foreach ($custom_fields as $custom_field) {

        $type = !empty($custom_field['type']) ? $custom_field['type'] : 'text';
        $name = !empty($custom_field['name']) ? $custom_field['name'] : '';
        $label = !empty($custom_field['label']) ? $custom_field['label'] : $name;
        $required = !empty($custom_field['required']) ? $custom_field['required'] : false;

        if ($type == "file") {
          if ($required && empty($_FILES[$name]['name'])) {
            $passed = false;
            $text = sprintf(__("Please upload a file for %s", 'woocommerce'), $label);
            wc_add_notice($text, 'error');
          } else {
            $allowed_mime_types = array('image/jpeg', 'image/png', 'application/pdf');
            $file_type = mime_content_type($_FILES[$name]['tmp_name']);
            if (!in_array($file_type, $allowed_mime_types)) {
              $passed = false;
              wc_add_notice(__('Invalid file type. Please upload a valid file.', 'woocommerce'), 'error');
            }
          }
        } else {
          if ($required && empty($_POST[$name])) {
            $passed = false;
            $text = sprintf(__("Please fill in the %s", 'woocommerce'), $label);
            wc_add_notice($text, 'error');
          }
        }
      }
    }

    return $passed;
  }
}
