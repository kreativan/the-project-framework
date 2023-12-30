<?php

/**
 * Custom Prices
 * Based on the ACF. In order to work, you need to create a custom field for the product
 * called "custom_price" and set the price for each role.
 * ACF Fields to create:
 * custom_prices (repeater)
 *  - user_roles (select)
 *  - type (radio: discount | price | variations)
 *  # when discount is selected:
 *  - discount (number)
 *  # when price is selected:
 *  - price (number)
 *  # when variation is selected:
 *  - min_max_price_text (text)
 *  - variations (repeater)
 *    - variation_id  (number)
 *    - variation_price (number)
 */

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class CustomPrices {

  public function __construct() {
    add_filter('woocommerce_product_get_price', [$this, 'custom_role_price'], 10, 2);
    add_filter('woocommerce_product_variation_get_price', [$this, 'modify_variation_price'], 10, 3);
    add_filter('woocommerce_variable_price_html', [$this, 'modify_variable_product_price_text'], 10, 2);
  }


  /**
   * Set variable product price text
   */
  public function modify_variable_product_price_text($price, $product) {
    if ($product->is_type('variable')) {
      $variation_prices = $product->get_variation_prices(true); // Get variation prices
      // Get the minimum and maximum prices
      $min_price = min($variation_prices['price']);
      $max_price = max($variation_prices['price']);
      // new price text
      $new_price_text = $this->get_min_max_price_text($product, $min_price, $max_price);
      return $new_price_text ?  $new_price_text : $price;
    }
    return $price; // Return the original price for other product types
  }

  /**
   * Set product variation prices
   */
  public function modify_variation_price($price, $variation) {
    $custom_price = $this->get_custom_variation_price($variation, $price);
    return $custom_price ? $custom_price : $price;
  }

  /**
   * Set product prices
   */
  public function custom_role_price($price, $product) {
    $custom_price = $this->get_custom_price($product, $price);
    if (!$custom_price) return $price;
    return $custom_price;
  }

  // --------------------------------------------------------- 
  // Helpers 
  // --------------------------------------------------------- 

  public function apply_discount($price, $percent) {
    $discount = (int) $percent;
    $price = (float) $price;
    $discounted_price = $price - ($price * ($discount / 100));
    return $discounted_price;
  }

  public function get_min_max_price_text($product, $min, $max) {

    $price_text = false;
    $discounted_text = false;

    if (!is_user_logged_in()) return false;

    // Get the current user object
    $user = wp_get_current_user();
    $role = $user->roles[0];

    // get product custom prices
    $custom_prices = get_field('custom_prices', $product->get_id());

    // if custom price is empty return false
    if (empty($custom_prices) || !count($custom_prices)) return false;

    // Loop trough custom prices and find matching price for the user role
    foreach ($custom_prices as $custom_price) {
      if ($custom_price['user_roles'] == $role) {
        if (!empty($custom_price['type']) && $custom_price['type'] == "discount") {
          $discount = (float) $custom_price['discount'];
          $min = $this->apply_discount($min, $discount);
          $max = $this->apply_discount($max, $discount);
          $discounted_text = wc_price($min) . ' - ' . wc_price($max);
        } else {
          $price_text = $custom_price['min_max_price_text'];
        }
      }
    }

    if ($price_text) {
      $price_text = explode('-', $price_text);
      $min_price = !empty($price_text[0]) ? $price_text[0] : 0;
      $max_price = !empty($price_text[1]) ? $price_text[1] : 0;
      if ($min_price && $max_price) {
        $price_text = wc_price($min_price) . ' - ' . wc_price($max_price);
      } else {
        $price_text = $price_text[0];
      }
    }

    return $discounted_text ? $discounted_text : $price_text;
  }

  /**
   * Get custom price
   * based on the custom ACF fields: custom_prices
   * @param $product
   * @return float|bool
   */
  public function get_custom_price($product, $price) {
    $new_price = false;
    $discounted_price = false;
    $price = (float) $price;

    if (!is_user_logged_in()) return false;

    // Get the current user object
    $user = wp_get_current_user();
    $role = $user->roles[0];

    // get product custom prices
    $custom_prices = get_field('custom_prices', $product->get_id());

    // if custom price is empty return false
    if (empty($custom_prices) || !count($custom_prices)) return false;

    // Loop trough custom prices and find matching price for the user role
    foreach ($custom_prices as $custom_price) {
      if ($custom_price['user_roles'] == $role) {
        if (!empty($custom_price['type']) && $custom_price['type'] == "discount") {
          $discount = (float) $custom_price['discount'];
          $discounted_price = $this->apply_discount($price, $discount);
        } else {
          $new_price = $custom_price['price'];
        }
      }
    }

    // If found custom price for the user role, return it
    if ($new_price && !empty($new_price)) {
      // remove sale price
      $product->set_sale_price('');
      $product->set_regular_price('');
      // Remove all other discounts
      $product->set_price('');
    }

    return $discounted_price ? $discounted_price : $new_price;
  }

  /**
   * Get custom variation price
   * based on the custom ACF fields: custom_prices => variations
   * @param $variation
   * @return float|bool
   */
  public function get_custom_variation_price($variation, $price) {
    $new_price = false;
    $discounted_price = false;
    $price = (float) $price;

    if (!is_user_logged_in()) return false;

    // Get the current user object
    $user = wp_get_current_user();
    $role = $user->roles[0];

    $variation_id = $variation->get_id();
    $parent_product_id = $variation->get_parent_id();
    $custom_prices = get_field('custom_prices', $parent_product_id);

    foreach ($custom_prices as $custom_price) {
      if ($custom_price['user_roles'] == $role) {
        if (!empty($custom_price['type']) && $custom_price['type'] == "discount") {
          $discount = (float) $custom_price['discount'];
          $discounted_price = $this->apply_discount($price, $discount);
        } else {
          $variation_prices = !empty($custom_price['variations']) ? $custom_price['variations'] : false;
          if ($variation_prices) {
            foreach ($variation_prices as $item) {
              if ($item['variation_id'] == $variation_id) {
                $new_price = (float) $item['variation_price'];
              }
            }
          }
        }
      }
    }

    return $discounted_price ? $discounted_price : $new_price;
  }
}
