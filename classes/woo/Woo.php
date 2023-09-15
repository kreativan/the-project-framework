<?php

namespace TPF;

class WOO {

  public function __construct($params = []) {


    // Add WooCommece support
    add_theme_support('woocommerce');

    // Breadcrumbs separator
    add_filter('woocommerce_breadcrumb_defaults', [$this, 'breadcrumb_separator']);

    // Disable scripts and styles
    if (the_project('woo_custom') == "1") {
      add_action('wp_enqueue_scripts', [$this, 'disable_woocommerce_assets'], 100);
      add_action('wp_enqueue_scripts', [$this, 'disable_woocommerce_styles'], 99);
      add_action('wp_enqueue_scripts', [$this, 'disable_woocommerce_scripts'], 99);
    }

    /**
     * Query
     * Watch for $_GET variables to apply filters
     */
    add_action('init', function () {
      $woo_query = new \TPF\Woo_Query;
      $woo_query->watch();
    });

    //  Discounts
    if (the_project('discounts')) {
      new Discounts;
    }

    //  Custom Markup
    if (the_project('woo_custom') == "1") {
      add_action('after_setup_theme', [$this, 'single']);
      add_action('after_setup_theme', [$this, 'loop']);
    }

    // change number of products per page
    /*
    add_filter('loop_shop_per_page', function ($cols) {
      return 12;
    }, 20);
    */
  }

  // --------------------------------------------------------- 
  // Change the breadcrumb separator
  // --------------------------------------------------------- 

  public function breadcrumb_separator($defaults) {
    $defaults['delimiter'] = ' <span class="breadcrumb-separator">/</span> ';
    return $defaults;
  }

  // --------------------------------------------------------- 
  // Remove blocks styles and scripts WC 8+ 
  // --------------------------------------------------------- 

  public function disable_woocommerce_assets() {

    /**
     * Array of styles to be removed
     */
    $styles = array(
      'wp-block-library',
      'wc-blocks-style',
      'wc-blocks-style-active-filters',
      'wc-blocks-style-add-to-cart-form',
      'wc-blocks-packages-style',
      'wc-blocks-style-all-products',
      'wc-blocks-style-all-reviews',
      'wc-blocks-style-attribute-filter',
      'wc-blocks-style-breadcrumbs',
      'wc-blocks-style-catalog-sorting',
      'wc-blocks-style-customer-account',
      'wc-blocks-style-featured-category',
      'wc-blocks-style-featured-product',
      'wc-blocks-style-mini-cart',
      'wc-blocks-style-price-filter',
      'wc-blocks-style-product-add-to-cart',
      'wc-blocks-style-product-button',
      'wc-blocks-style-product-categories',
      'wc-blocks-style-product-image',
      'wc-blocks-style-product-image-gallery',
      'wc-blocks-style-product-query',
      'wc-blocks-style-product-results-count',
      'wc-blocks-style-product-reviews',
      'wc-blocks-style-product-sale-badge',
      'wc-blocks-style-product-search',
      'wc-blocks-style-product-sku',
      'wc-blocks-style-product-stock-indicator',
      'wc-blocks-style-product-summary',
      'wc-blocks-style-product-title',
      'wc-blocks-style-rating-filter',
      'wc-blocks-style-reviews-by-category',
      'wc-blocks-style-reviews-by-product',
      'wc-blocks-style-product-details',
      'wc-blocks-style-single-product',
      'wc-blocks-style-stock-filter',
      'wc-blocks-style-cart',
      'wc-blocks-style-checkout',
      'wc-blocks-style-mini-cart-contents',
      'classic-theme-styles-inline'
    );

    /**
     * Array of scripts to be removed
     */
    $scripts = array(
      'wc-blocks-middleware',
      'wc-blocks-data-store',
    );

    // remove wp util if not on product page
    // and scripts added by product swatches
    if (!is_product()) {
      $scripts[] = 'wp-util';
    }

    foreach ($styles as $style) wp_deregister_style($style);
    foreach ($scripts as $script) wp_deregister_script($script);
  }

  // --------------------------------------------------------- 
  // Legacy disable styles & scripts 
  // --------------------------------------------------------- 

  public function disable_woocommerce_styles() {
    wp_dequeue_style('wc-blocks-style');
    wp_dequeue_style('classic-theme-styles');
    // wp_dequeue_style('woocommerce-general'); // comment this to keep some default woocommerce style
    wp_dequeue_style('woocommerce-layout');
    wp_dequeue_style('woocommerce-smallscreen');
    wp_dequeue_style('woocommerce_frontend_styles');
    wp_dequeue_style('woocommerce_fancybox_styles');
  }

  function disable_woocommerce_scripts() {
    // Check if not on cart or checkout pages
    if (!is_cart() && !is_checkout() && !is_account_page()) {
      // Dequeue WooCommerce scripts
      wp_dequeue_script('wc-cart-fragments');
      wp_dequeue_script('woocommerce');
      wp_dequeue_script('wc-add-to-cart');
      wp_dequeue_script('wc-cart');
      wp_dequeue_script('wc-checkout');
      wp_dequeue_script('wc-add-payment-method');
      wp_dequeue_script('wc-lost-password');
      wp_dequeue_script('wc-password-strength-meter');
      // wp_dequeue_script('wc-single-product'); // comment this to keep scripts on single product page
      wp_dequeue_script('wc-add-to-cart-variation');
      wp_dequeue_script('wc-email-validation');
      wp_dequeue_script('wc-credit-card-form');
      wp_dequeue_script('wc-address-i18n');
      wp_dequeue_script('wc-country-select');
    }
  }

  // --------------------------------------------------------- 
  // Single Product 
  // --------------------------------------------------------- 

  public function single() {

    // remove stock html
    add_filter('woocommerce_get_stock_html', function ($html, $product) {
      return '';
    }, 10, 2);

    // Remove Reviews tab
    add_filter('woocommerce_product_tabs', function ($tabs) {
      unset($tabs['reviews']);
      return $tabs;
    }, 98);
  }

  // --------------------------------------------------------- 
  // Product Loop 
  // --------------------------------------------------------- 

  public function loop() {

    // remove shop title
    add_filter('woocommerce_show_page_title', '__return_false');

    // remove category & taxonomy descriptions
    remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
  }
}
