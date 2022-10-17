<?php
/**
 *  WooCommerce discounts
 *  @author Ivan Milincic <kreativan.dev@gmail.com>
 *  @link http://kraetivan.dev
*/

class The_Project_Discounts {

  public function __construct($data = []) {
    
    // Create post type
    new The_Project_Post_Type([
      "name" => "project_discounts",
      "slug" => 'project-discounts',
      "title" => __('Discounts'),
      "item_title" => __('Discount'),
      "show_in_menu" => "false", // do not show in root admin menu
      "show_in_nav_menus" => "false",
      "exclude_from_search" => "false",
      "supports" => ['title'],
      "has_archive" => "false",
      "taxonomy" => "false",
      "admin_columns" => [
        'enable' => 'Enabled',
        'percent' => 'Percent',
        'user_roles' => 'Roles',
        'discount_product_category' => 'Categories'
      ]
    ]);

    // Create submenu
    new The_Project_Sub_Menu([
      "title" => __('Discounts'),
      "slug" => "edit.php?post_type=project_discounts" // sort by latest
    ]);

    // Run filter
    if(!is_admin() && $this->is_discount()) {
      add_filter('woocommerce_product_get_regular_price', [$this, 'apply_discount'], 10, 2);
      add_filter('woocommerce_product_get_sale_price', [$this, 'apply_discount'], 10, 2);
      add_filter('woocommerce_product_get_price', [$this, 'apply_discount'], 10, 2);
    }

  }

  //-------------------------------------------------------- 
  //  Apply Discount
  //-------------------------------------------------------- 

  public function apply_discount($orginal_price, $product) {

    if(!$orginal_price) return;
    
    $new_price = $orginal_price;

    $u = wp_get_current_user();

    $cat_arr = [];
    $cats = get_the_terms($product->get_id(), 'product_cat');
    if($cats && count($cats) > 0) {
      foreach($cats as $cat) $cat_arr[] = $cat->slug;
    }

    $params = [
      "discount_product_category" => $cat_arr,
      "role" => $u->roles ? $u->roles[0] : "",
    ];

    $discounts = $this->get_discounts($params);

    if($discounts) {
      foreach($discounts as $discount) {
        $new_price = $this->add_percent($discount['percent'], $new_price);
      }
    }

    //dump($discounts);

    return $new_price;

  }

  //-------------------------------------------------------- 
  //  Methods
  //-------------------------------------------------------- 

  public function is_discount() {
    if ( $this->get_discounts() ) return true;
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
      'numberposts'	=> -1,
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
    if($role) {

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

    if($product_category) {

      foreach($product_category as $category) {
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

      foreach($posts as $item) {
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