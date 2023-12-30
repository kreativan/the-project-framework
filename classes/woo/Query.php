<?php

/**
 * Woo Query
 * You can use this class to modify WooCommerce query products on the front-end.
 * Use $this->watch() to watch for $_GET parameters
 */

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class Woo_Query {

  public $search_filters;

  public function __construct() {
    $this->search_filters = new \TPF\SearchFilters;
  }

  /**
   * Watch
   * Add filters to the watch list
   * @param name is the $_GET parameter
   * @param method is name of the method to call
   * @param params are the parameters to pass to the method
   */
  public function watch() {
    // Get filters array from the filters class
    $filter_groups = $this->search_filters->filters();

    /**
     * Loop trough filter groups
     * and add filter by filter to the watch list (query)
     * Radio and select as single options are added to the query by group[name] = filter[value]
     * All checkboxes are added to the query as they are multi-value
     */
    foreach ($filter_groups as $group) {
      if ($group['type'] == "radio" || $group['type'] == "select") {
        foreach ($group['items'] as $filter) {
          $GET_NAME = isset($_GET[$group['name']]) ? $_GET[$group['name']] : false;
          if ($filter['value'] == $GET_NAME) {
            // $filters[] = $filter;
            $name = $group['name'];
            $method = $filter['method'];
            $params = !empty($filter['params']) ? $filter['params'] : [];
            if (isset($_GET[$name])) {
              add_action('woocommerce_product_query', function ($q) use ($method, $params) {
                $this->{$method}($q, $params);
              });
            }
          }
        }
      } else {
        foreach ($group['items'] as $filter) {
          // $filters[] = $filter;
          $name = $filter['name'];
          $method = $filter['method'];
          $params = !empty($filter['params']) ? $filter['params'] : [];
          if (isset($_GET[$name])) {
            add_action('woocommerce_product_query', function ($q) use ($method, $params) {
              $this->{$method}($q, $params);
            });
          }
        }
      }
    }
  }

  // --------------------------------------------------------- 
  // Methods 
  // --------------------------------------------------------- 

  /**
   * Filter products by any meta data
   * @param string $key
   * @param string $value
   * @param string $compare
   */
  public function by_meta($q, $params) {
    if (is_admin() || !$q->is_main_query()) return;

    $key = isset($params['key']) ? $params['key'] : false;
    $value = isset($params['value']) ? $params['value'] : false;
    $compare = isset($params['compare']) ? $params['compare'] : '=';

    if (!$key || !$value) return;

    // Get current meta query
    $meta_query = $q->get('meta_query');
    $meta_query = $meta_query ? $meta_query : array();

    // Add your custom meta query conditions here
    $meta_query[] = array(
      'key'     => $key,
      'value'   => $value,
      'compare' => $compare,
    );

    $q->set('meta_query', $meta_query);

    return $q;
  }

  /**
   * Only show sale products
   * @example add_action('woocommerce_product_query', 'on_sale');
   */
  public function on_sale($q) {
    if (is_admin() || !$q->is_main_query()) return;

    // Get current meta query
    $meta_query = $q->get('meta_query');
    $meta_query = $meta_query ? $meta_query : array();

    // Add "On Sale" condition to the meta query
    $meta_query[] = array(
      'relation' => 'OR',
      array(
        'key'     => '_sale_price',
        'compare' => 'EXISTS',
      ),
      array(
        'key'     => '_price',
        'compare' => '=',
        'value'   => '',
      ),
    );

    $q->set('meta_query', $meta_query);
  }

  /**
   * Only show products with a min rating
   * @param int $min
   * @param int $max
   */
  public function with_rating($q, $params = []) {
    if (is_admin() || !$q->is_main_query()) return;

    $min = isset($params['min']) ? $params['min'] : false;
    $max = isset($params['max']) ? $params['max'] : false;

    if (!$min && !$max) return;

    if ($min && $max) {
      $value = [$min, $max];
      $compare = 'BETWEEN';
    } elseif ($min) {
      $value = $min;
      $compare = '>=';
    } elseif ($max) {
      $value = $max;
      $compare = '<=';
    }

    // Get current meta query
    $meta_query = $q->get('meta_query');
    $meta_query = $meta_query ? $meta_query : array();

    // Custom meta query
    $meta_query[] = array(
      'key'     => '_wc_average_rating',
      'value'   => $value,
      'compare' => $compare,
    );

    $q->set('meta_query', $meta_query);
  }

  /**
   * Filter products by price
   * @param int|float $min
   * @param int|float $max
   */
  public function by_price($q, $params = []) {
    if (is_admin() || !$q->is_main_query()) return;

    $min = isset($params['min']) ? $params['min'] : false;
    $max = isset($params['max']) ? $params['max'] : false;

    if (!$min && !$max) return;

    if ($min && $max) {
      $value = [$min, $max];
      $compare = 'BETWEEN';
    } elseif ($min) {
      $value = $min;
      $compare = '>=';
    } elseif ($max) {
      $value = $max;
      $compare = '<=';
    }

    // Get current meta query
    $meta_query = $q->get('meta_query');
    $meta_query = $meta_query ? $meta_query : array();

    // Custom meta query
    $meta_query[] = array(
      'key'     => '_price',
      'value'   => $value,
      'type'    => 'numeric',
      'compare' => $compare,
    );

    $q->set('meta_query', $meta_query);
  }
}
