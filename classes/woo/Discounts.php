<?php

namespace TPF;

/**
 * WooCommerce Discounts
 * Create discounts based on a suer role and product category
 * Discounts will be applied on product price, regular price and sale price
 * User will not see original price anywhere.
 * @author Ivan Milincic <kreativan.dev@gmail.com>
 * @link http://kraetivan.dev
 */

class Discounts {

  public function __construct($data = []) {

    new Post_Type([
      'name' => "project_discounts",
      "title" => 'Discounts',
      "singular_name" => "Discount",
      "icon" => "dashicons-feedback",
      "menu_position" => 5,
      "submenu_title" => "Discounts",
      "admin_columns" => [
        'enable' => 'Enabled',
        'percent' => 'Percent',
        'user_roles' => 'Roles',
        'discount_product_category' => 'Categories'
      ],
    ]);

    // populate discount_product_category
    if (is_admin()) {
      add_filter('acf/load_field/name=discount_product_category', [$this, 'acf_product_categories']);
    }

    // Run filter
    if (!is_admin() && $this->is_discount()) {
      //add_filter('woocommerce_product_get_regular_price', [$this, 'apply_discount'], 10, 2);
      //add_filter('woocommerce_product_get_sale_price', [$this, 'apply_discount'], 10, 2);
      add_filter('woocommerce_product_get_price', [$this, 'apply_discount'], 10, 2);
    }

    // ACF discounts field group
    if (function_exists('acf_add_local_field_group')) {
      tpf_acf_group_init('discounts');
    }
  }

  /** populate discount_product_category */
  public function acf_product_categories($field) {
    // reset choices
    $field['choices'] = [];
    $array = [];

    $categories = get_terms(['taxonomy' => 'product_cat']);
    foreach ($categories as $cat) {
      $array[$cat->slug] = $cat->name;
    }
    $field['choices'] = $array;

    return $field;
  }

  //-------------------------------------------------------- 
  //  Apply Discount
  //-------------------------------------------------------- 

  public function apply_discount($orginal_price, $product) {

    if (!is_user_logged_in()) return $orginal_price;

    $new_price = false;

    // Get current user
    $u = wp_get_current_user();
    $role = $u->roles[0];

    // Custom Prices Integration
    // Lets first check for custom prices
    // get product custom prices
    $custom_prices = get_field('custom_prices', $product->get_id());
    // if custom price is empty return false
    if (!empty($custom_prices) && count($custom_prices)) {
      // Loop trough custom prices and find matching price for the user role
      foreach ($custom_prices as $custom_price) {
        if ($custom_price['user_roles'] == $role) {
          return $orginal_price;
        }
      }
    }

    // There is no product custom price for the user role
    // Continue ...


    $cat_arr = [];
    $cats = get_the_terms($product->get_id(), 'product_cat');
    if ($cats && count($cats) > 0) {
      foreach ($cats as $cat) $cat_arr[] = $cat->slug;
    }

    $params = [
      "discount_product_category" => $cat_arr,
      "role" => $u->roles ? $u->roles[0] : "",
    ];

    $discounts = $this->get_discounts($params);

    if ($discounts) {

      // Any discount will be applied to the regular price
      // sale price will be ignored
      $regular_price = $product->get_regular_price();

      foreach ($discounts as $discount) {
        $new_price = $this->add_percent($discount['percent'], $regular_price);
      }

      if ($new_price) {
        $product->set_sale_price('');
        $product->set_regular_price('');
        $product->set_price($new_price);
        return $new_price;
      }
    }

    return $orginal_price;
  }

  //-------------------------------------------------------- 
  //  Methods
  //-------------------------------------------------------- 

  public function is_discount() {
    if ($this->get_discounts()) return true;
    return true;
  }

  public function add_percent($percent, $price) {
    $discount = (float) ($percent / 100) * (float) $price;
    $new_price = (float) $price - (float) $discount;
    return $new_price;
  }

  //-------------------------------------------------------- 
  //  Get Discounts
  //-------------------------------------------------------- 

  /**
   * Get discoutns based on parametars
   * @param string $role
   * @param array $product_category
   * @return array|bool
   */
  public function get_discounts($params = []) {

    // Function params
    $role = isset($params['role']) ? $params['role'] : false;
    $product_category = isset($params['discount_product_category']) ? $params['discount_product_category'] : false;

    // Query arguments
    $args = [
      'numberposts'  => -1,
      'post_type' => 'project_discounts',
      "meta_query" => [],
    ];

    // enabled
    $args['meta_query'][] = [
      'key'     => 'enable',
      'value'   => '1',
      'compare' => '=',
    ];

    /**
     * Roles
     */
    if ($role) {

      $args['meta_query'][] = [
        "relation" => 'OR',
        [
          'key'     => 'user_roles',
          'value'   => 'all',
          'compare' => '=',
        ],
        [
          'key'     => 'user_roles',
          'value'   => $role,
          'compare' => '=',
        ]
      ];
    } else {

      $args['meta_query'][] = [
        'key'     => 'user_roles',
        'value'   => 'all',
        'compare' => '=',
      ];
    }

    /**
     * product_category 
     */

    $category_array = [
      "relation" => 'OR',
    ];

    $category_array[] = [
      'key'     => 'discount_product_category',
      'value'   => '',
      'compare' => '=',
    ];

    if ($product_category) {

      foreach ($product_category as $category) {
        $category_array[] = [
          'key'     => 'discount_product_category',
          'value'   => $category,
          'compare' => 'LIKE',
        ];
      }

      $args['meta_query'][] = $category_array;
    }

    // Run query (use get_posts() instead)
    // $query = new WP_Query($args);

    // We are going to store our data here
    $data = [];

    $posts = get_posts($args);

    if ($posts) {

      foreach ($posts as $item) {
        $data[] = [
          "title" => $item->post_title,
          "percent" => get_field('percent', $item->ID),
          "categories" => get_field('discount_product_category', $item->ID),
        ];
      }

      return $data;
    } else {
      return false;
    }

    return $data;
  }
}
