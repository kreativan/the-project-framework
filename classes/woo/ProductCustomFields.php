<?php

/**
 * Product Custom Fields
 * Works with ACF, so you need to create a acf flexible field 
 * with name "custom_fields" and asign it to the product page
 * custom_fields: 
 *  - text
 *  - file
 * Subfields:
 *  - label
 *  - placeholder
 *  - required
 *  - description
 *  - options
 *  - default
 */

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class ProductCustomFields {

  public $upload_folder;
  public $allowed_mime_types;

  public function __construct() {

    // File upload folder
    $this->upload_folder = 'orders';
    // Allowed file types
    $this->allowed_mime_types = array('image/jpeg', 'image/jpg', 'image/png', 'application/pdf');

    /**
     * Register the file field on the product page
     */
    add_action('woocommerce_before_add_to_cart_button', [$this, 'register_custom_fields']);

    /**
     * Cart and Checkout
     */
    add_action('woocommerce_add_cart_item_data', [$this, 'save_custom_fields'], 10, 2);
    add_filter('woocommerce_get_item_data', [$this, 'display_custom_fields'], 10, 2);
    add_filter('woocommerce_add_to_cart_validation', [$this, 'validate_custom_fields'], 10, 3);

    /**
     * Order
     */
    add_action('woocommerce_checkout_create_order_line_item', [$this, 'order_save_custom_fields'], 10, 4);
  }

  // --------------------------------------------------------- 
  // Helpers 
  // --------------------------------------------------------- 

  public function get_custom_fields($product_id) {
    $custom_fields = get_field('custom_fields', $product_id);
    if (empty($custom_fields) || count($custom_fields) < 1) return false;
    return $custom_fields;
  }

  public function field_name($label) {
    $name = str_replace(' ', '_', $label);
    $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
    $name = strtolower($name);
    return $name;
  }

  // --------------------------------------------------------- 
  // Register
  // --------------------------------------------------------- 

  public function register_custom_field() {

    global $product;

    $product_id = $product->get_id();

    $custom_fields = $this->get_custom_fields($product_id);
    if (!$custom_fields) return;

    foreach ($custom_fields as $custom_field) {

      $type = $custom_field['acf_fc_layout'];
      $label = $custom_field['label'];
      $name = $this->field_name($label);

      $placeholder = !empty($custom_field['placeholder']) ? $custom_field['placeholder'] : '';
      $required = !empty($custom_field['required']) ? $custom_field['required'] : false;
      $description = !empty($custom_field['description']) ? $custom_field['description'] : '';
      $options = !empty($custom_field['options']) ? $custom_field['options'] : [];
      $default = !empty($custom_field['default']) ? $custom_field['default'] : '';

      echo "<div class='woo-custom-field uk-margin-small'>";

      if ($type == "file") {

        $required = $required ? 'required' : '';
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
  // Cart and Checkout - Save and Display
  // ---------------------------------------------------------

  /**
   * Save custom fields to the cart data
   */
  public function save_custom_fields($cart_item_data, $product_id) {

    $custom_fields = $this->get_custom_fields($product_id);
    if (!$custom_fields) return $cart_item_data;

    foreach ($custom_fields as $custom_field) {

      $type = $custom_field['acf_fc_layout'];
      $label = $custom_field['label'];
      $name = $this->field_name($label);

      if ($type == "file") {
        if (!empty($_FILES[$name]['name'])) {

          // get current user id
          $user_id = get_current_user_id();

          // upload file to the orders folder
          $upload_dir = wp_upload_dir();
          $main_upload_path = $upload_dir['basedir'] . "/{$this->upload_folder}/";
          $upload_path = $main_upload_path . "{$user_id}/";
          $upload_url = $upload_dir['baseurl'] . "/{$this->upload_folder}/$user_id/";
          // create directory if it doesn't exist
          if (!file_exists($main_upload_path)) mkdir($main_upload_path, 0755, true);
          if (!file_exists($upload_path)) mkdir($upload_path, 0755, true);

          // Uploaded file
          $upload_file = $upload_path . basename($_FILES[$name]['name']);
          $upload_url_file = $upload_url . basename($_FILES[$name]['name']);

          // Check if file has right extension: pdf, jpg, jpeg
          $file_type = mime_content_type($_FILES[$name]['tmp_name']);
          if (!in_array($file_type, $this->allowed_mime_types)) {
            wc_add_notice(__('Invalid file type. Please upload a valid file.', 'woocommerce'), 'error');
            return $cart_item_data;
          }

          // Upload file
          move_uploaded_file($_FILES[$name]['tmp_name'], $upload_file);

          // save file data to cart item data
          $cart_item_data[$name] = $upload_file;
          $cart_item_data[$name . '_file_name'] = basename($upload_file);
          $cart_item_data[$name . '_url'] = '/ajax/force-open/?file_path=' . $upload_url_file;
        }
      } else {
        if (isset($_POST[$name])) {
          $cart_item_data[$name] = sanitize_text_field($_POST[$name]);
        }
      }
    }

    return $cart_item_data;
  }

  /**
   * Display custom fields on cart and checkout
   */
  public function display_custom_field($item_data, $cart_item) {

    $product_id = $cart_item['product_id'];
    $custom_fields = $this->get_custom_fields($product_id);
    if (!$custom_fields) return $item_data;

    foreach ($custom_fields as $custom_field) {

      $type = $custom_field['acf_fc_layout'];
      $label = $custom_field['label'];
      $name = $this->field_name($label);

      if ($type == "file") {
        if (isset($cart_item[$name])) {
          $file_name = basename($cart_item[$name]['file']);
          $item_data[] = array(
            'key'     => __($label, 'woocommerce'),
            'value'   => $file_name,
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

    //  dump($item_data);

    return $item_data;
  }

  /**
   * Validate custom fields on cart and checkout
   */
  public function validate_custom_field($passed, $product_id, $quantity) {

    $custom_fields = $this->get_custom_fields($product_id);

    if ($custom_fields) {
      foreach ($custom_fields as $custom_field) {

        $type = $custom_field['acf_fc_layout'];
        $label = $custom_field['label'];
        $name = $this->field_name($label);
        $required = $custom_field['required'];

        if ($type == "file") {
          if ($required && empty($_FILES[$name]['name'])) {
            $passed = false;
            $text = sprintf(__("Please upload a file for %s", 'woocommerce'), $label);
            wc_add_notice($text, 'error');
          } else {
            $allowed_mime_types = $this->allowed_mime_types;
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

  // --------------------------------------------------------- 
  // Orders
  // --------------------------------------------------------- 

  /**
   * Save custom fields to order
   * They will be automatically displayed on the order page
   */
  function order_save_custom_fields($item, $cart_item_key, $values, $order) {

    $product_id = $item->get_product_id();
    $custom_fields = $this->get_custom_fields($product_id);

    if ($custom_fields) {
      foreach ($custom_fields as $custom_field) {
        $type = $custom_field['acf_fc_layout'];
        $label = $custom_field['label'];
        $name = $this->field_name($label);

        // Get the value of this custom field from the cart item
        if ($type == "file") {
          $file_name = $values[$name . '_file_name'];
          $file_url = $values[$name . '_url'];
          $value = "<a href='{$file_url}?TB_iframe=true&width=640&height=480' target='_blank' class='thickbox uikit-lightbox'>$file_name</a>";
          $item->add_meta_data($label, $value);
        } else {
          $value = !empty($values[$name]) ? $values[$name] : '';
          $item->add_meta_data($label, $value);
        }
      }
    }
  }
}
