<?php

/**
 * Custom Coupons Stuff
 * - Validate coupon by vendor (ACF field added to coupon and product)
 */

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class Coupons {

  public function __construct() {
    add_filter('woocommerce_coupon_is_valid', [$this, 'vendor_coupon_check'], 10, 4);
  }


  /**
   * Validate coupon by vendor
   * vendor is ACF field added to coupon and product
   */
  public function vendor_coupon_check($is_valid, $coupon) {

    // Get the vendor selected in the coupon custom field.
    $coupon_vendor = get_field('vendor', $coupon->get_id());

    // If no vendor is selected, return the default value.
    if (empty($coupon_vendor) || $coupon_vendor == "") {
      return $is_valid;
    }

    $cart = WC()->cart->get_cart();
    $valid = true; // Assume all products are valid initially

    foreach ($cart as $cart_item_key => $cart_item) {
      $product_id = $cart_item['product_id'];

      // Get the product's vendor.
      $product_vendor = get_field('vendor', $product_id);

      if ($coupon_vendor->post_name != $product_vendor->post_name) {
        $valid = false;
        break;
      }
    }

    return $valid ? $is_valid : false;
  }
}
