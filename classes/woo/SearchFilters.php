<?php

/**
 * WooCommerce Search Filters
 * 
 * @example update search filter array
 * 
 *  add_action('init', function () {
 *    add_filter('tpf_search_filters', function($filters) {
 * 
 *      $filters['custom'] = [
 *       'name' => 'custom',
 *       'method' => 'by_meta',
 *       'params' => [
 *          'key' => 'custom',
 *          'value' => 203,
 *          'compare' => '=',
 *        ],
 *      ];
 *  
 *      return $filters;
 * 
 *    });
 *  }
 */

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class SearchFilters {

  public function __construct() {
    add_filter('acf/fields/flexible_content/layout_title/name=items', [$this, 'flexible_field_labels'], 10, 4);
    // ...
  }


  public function create_post_type() {
    new Post_Type([
      'name' => "project-filters",
      "title" => 'Search Filters',
      "singular_name" => "Search Filter",
      "icon" => "dashicons-feedback",
      "menu_position" => 100,
      "submenu_title" => __("Search Filters", "the-project-framework"),
      "show_in_menu" => 'site-settings',
      "admin_columns" => [
        'type' => "Type",
        'category' => 'Category',
        'sort' => 'Sort',
      ],
    ]);
  }

  /**
   * Set layout labels based on the title or headline fields
   */
  public function flexible_field_labels($title, $field, $layout, $i) {
    $subfield  = get_sub_field("label");
    // Check if the title already contains the label
    if (strpos($title, $subfield) !== false) {
      return $title; // If label is already present, return as is
    }
    // Add the label to the title
    $title .= ' - ' . $subfield;

    return $title;
  }

  // --------------------------------------------------------- 
  // Methods 
  // --------------------------------------------------------- 

  /**
   * Search filters
   * Get array of filters from custom post types
   * @return array
   */
  public function filters() {
    $filters = [];
    // get custom post types with name project_filters
    $filters_posts = $this->get_filter_groups();
    foreach ($filters_posts as $post) {
      $items = $this->get_filter_items($post);
      $title = $post->post_title;
      // $filters[$title] = $items;
      $filters[$title] = [
        "id" => $post->ID,
        "title" => $post->post_title,
        "category" => get_field('category', $post->ID),
        "type" => get_field('type', $post->ID),
        "name" => wc_sanitize_taxonomy_name($post->post_title),
        "sort" => get_field('sort', $post->ID),
        "items" => $items,
      ];
    }
    $filters = apply_filters('tpf_search_filters', $filters);
    return $filters;
  }

  /**
   * Get search filters custom posts
   * @return array
   */
  public function get_filter_groups() {

    $args = [
      'post_type' => 'project-filters',
      'numberposts' => -1,
      'meta_key' => 'sort',
      "orderby" => 'meta_value',
      'order' => 'ASC',
      "meta_query" => [
        "relation" => 'OR',
        [
          'key' => 'category',
          'value' => '',
          'compare' => '=',
        ]
      ],
    ];

    if (!is_shop()) {
      $current_category_id = get_queried_object_id();
      $args['meta_query'][] = [
        'key'     => 'category',
        'value'   => $current_category_id,
        'compare' => 'LIKE',
      ];
    }

    $filters_posts = get_posts($args);

    return $filters_posts;
  }

  /**
   * Get filters from the post flexible field
   * @param object $post
   * @return array
   */
  public function get_filter_items($post) {
    $post_id = $post->ID;
    $type = get_field('type', $post_id);
    $filters = [];
    $items = get_field('items', $post_id);
    foreach ($items as $item) {

      $layout = $item['acf_fc_layout'];
      $label = $item['label'];
      $name = wc_sanitize_taxonomy_name($label);

      if ($layout == 'on_sale') {
        $filters[$label] = [
          'name' => 'on_sale',
          'value' => 1,
          'method' => 'on_sale',
          'params' => [],
        ];
      } elseif ($layout == 'with_rating') {
        $filters[$label] = [
          'name' => 'with_rating',
          'value' => 1,
          'method' => 'with_rating',
          'params' => [],
        ];
      } elseif ($layout == 'by_price') {
        $filters[$label] = [
          'name' => $name,
          'value' => $item['min'] . "|" . $item['max'],
          'method' => 'by_price',
          'params' => [
            'min' => $item['min'],
            'max' => $item['max'],
          ],
        ];
      } elseif ($layout == 'by_meta') {
        $filters[$label] = [
          'name' => $name,
          'value' => ($type == 'checkbox') ? "1" : $item['key'] . "|" . $item['value'],
          'method' => 'by_meta',
          'params' => [
            'key' => $item['key'],
            'value' => $item['value'],
            'compare' => '=',
          ],
        ];
      }
    }
    return $filters;
  }
}
