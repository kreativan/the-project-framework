<?php

/**
 * Woo Query
 * You can use this class to modify the query for WooCommerce
 * use $this->watch() to watch for $_GET parameters
 * and $this->woo_filter($method) to add a filter to watch
 * 
 *  Use methods manually
 *  
 *  @example
 *  $woo_query = new \TPF\Woo_Query;
 *  add_action('woocommerce_product_query', [$woo_query, 'on_sale']);
 * 
 *  @example With additional parameters
 *  add_action('woocommerce_product_query', function($q) use ($woo_query) {
 *    $woo_query->with_rating($q, 3);
 *  });
 * 
 *  @example update query array using filter
 *  add_action('init', function () {
 *    add_filter('tpf_woo_query_filters', function($filters) {
 *      $filters['Min/Max Price] = [
 *        'name' => 'from_10_20',
 *        'method' => 'by_price',
 *        'params' => ['min' => 10, 'max' => 20],
 *      ];
 *      $filters['My Brand'] = [
 *       'name' => 'brand',
 *        'method' => 'by_meta',
 *        'params' => [
 *          'key' => 'brand',
 *          'value' => 203,
 *          'compare' => '=',
 *      ];
 *      return $filters;
 *    });
 *  }
 *
 */

namespace TPF;

class Woo_Query {

  public function __construct() {
  }

  /**
   * Define default filters here
   * - name is the $_GET parameter
   * - method is name of the method to call
   * - params are the parameters to pass to the method
   */
  public function filters() {
    $filters = [
      'On Sale' => [
        'name' => 'on_sale',
        'value' => 1,
        'method' => 'on_sale',
        'params' => [],
      ],
      'With Rating' => [
        'name' => 'with_rating',
        'value' => 1,
        'method' => 'with_rating',
        'params' => ['min' => 1],
      ],
    ];
    $filters = apply_filters('tpf_woo_query_filters', $filters);
    return $filters;
  }

  /**
   * Set Filters
   * Only for "predefined" params, additional parameters are not supported
   * $key => $val
   * where 
   * - name is the $_GET parameter
   * - method is name of the method to call
   * - params are the parameters to pass to the method
   */
  public function watch($filters = []) {
    $filters = count($filters) > 0 ? $filters : $this->filters();
    foreach ($filters as $filter) {
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
