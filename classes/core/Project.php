<?php

/**
 * The_Project class
 * This is the main procject class
 * Init this class in the main plugin file
 */

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class The_Project {

  public $gutenberg;
  public $menu;
  public $title;
  public $icon;
  public $ajax;
  public $htmx;
  public $htmx_version;
  public $acf_options;

  public function __construct($data) {

    $this->gutenberg = !empty($data["gutenberg"]) && $data["gutenberg"] == "true" ? true : false;
    $this->menu = !empty($data["menu"]) && $data["menu"] == "false" ? false : true;
    $this->title = !empty($data["title"]) ? $data["title"] : '';
    $this->icon = !empty($data["icon"]) ? $data["icon"] : 'dashicons-superhero';
    $this->ajax = !empty($data["ajax"]) && $data["ajax"] == "false" ? false : true;
    $this->htmx = !empty($data["htmx"]) && $data["htmx"] == "false" ? false : true;
    $this->htmx_version = !empty($data["htmx_version"]) ? $data["htmx_version"] : '1.7.0';
    $this->acf_options = !empty($data['acf_options']) && $data['acf_options'] != "false" ? $data['acf_options'] : false;

    // Theme Support
    add_theme_support('title-tag');
    add_theme_support('menus');
    add_theme_support('post-thumbnails');

    //
    //  Actions
    //

    // Admin actions
    if (is_admin()) {
      add_action('init', [$this, 'admin_assets']);
    }

    // allow svg uploads 
    add_filter('upload_mimes', [$this, 'cc_mime_types']);

    // Admin menu
    if ($this->menu) add_action('admin_menu', [$this, 'project_admin_menu']);

    // ACF Options
    if ($this->acf_options) $this->acf_website_settings($this->acf_options);

    // Assets
    add_action('wp_enqueue_scripts', [$this, 'load_assets'], 999);

    // Ajax 
    if ($this->ajax) add_action('template_redirect', [$this, 'ajax_route']);

    // Dont show private menus
    add_filter('wp_nav_menu_objects', [$this, 'filter_private_pages_from_menu'], 10, 2);

    // pagination 404 fix
    add_action('pre_get_posts', [$this, 'custom_pre_get_posts']);

    /**
     * Render layout file on htmx request
     * @example ./?htmx=layout/home/hero
     */
    add_action('wp_loaded', function () {
      if (!is_admin() && $this->get_htmx_file()) {
        $layout = $this->get_htmx_file();
        render($layout, $_GET);
        exit();
      }
    });

    /**
     * Dashboard Widget
     * if current user is administrator
     */
    add_action('init', function () {
      if (current_user_can('administrator')) {
        add_action('wp_dashboard_setup', [$this, 'add_dashboard_widget']);
      }
    });
  }

  // --------------------------------------------------------- 
  // Admin Pages 
  // --------------------------------------------------------- 

  // Project Main Menu
  public function project_admin_menu() {

    // Main Page
    add_menu_page(
      $this->title, // title
      $this->title, // menu_title
      'manage_options', // permision
      'site-settings', // slug - 'project' or 'site-settings'
      null, // null or callback function [$this, 'project_render_view'],
      $this->icon, // icon
      2, // position/sort
    );

    add_submenu_page(
      'site-settings', // main menu slug default: 'project'
      'Options', // title
      'Options', // menu_title
      'manage_options', // permission
      "admin.php?page=site-settings", // slug 
      null, // callback function
      0,
    );
  }

  /**
   *  Website Settings
   */
  public function acf_website_settings($title = 'Site Settings') {
    if (function_exists('acf_add_options_page')) {

      // Create options page
      acf_add_options_page([
        'page_title' => $title,
        'menu_title' => $title,
        'menu_slug' => 'site-settings',
        'capability' => 'manage_options',
        'parent_slug' => 'project',
        'position' => '1',
      ]);
    }
  }

  // render project view file
  public function project_render_view() {
    $view_file = tpf_path() . "admin/views/dashboard.php";
    if (file_exists($view_file)) include($view_file);
  }

  // --------------------------------------------------------- 
  // Dashboard 
  // --------------------------------------------------------- 

  function add_dashboard_widget() {
    wp_add_dashboard_widget(
      'the_project_widget', // Widget slug
      'The Project', // Widget title
      [$this, 'the_project_widget'], // Callback function to render widget content
      'side',
      'high',
    );
  }

  function the_project_widget() {
    include(tpf_path() . "admin/views/dashboard-widget.php");
  }


  // ========================================================= 
  // Assets 
  // ========================================================= 

  /**
   * load assets on front end
   */
  public function load_assets() {

    // If not woocomemrce page disable jquery
    if (!is_plugin_active('query-monitor/query-monitor.php') && function_exists('is_cart') && !is_cart() && !is_checkout() && !is_account_page() && !is_product()) {
      wp_deregister_script('jquery');
      wp_deregister_script('jquery-migrate');
    }

    // reset
    if (!$this->gutenberg) {
      wp_dequeue_style('wp-block-library'); // Wordpress core
      wp_dequeue_style('wp-block-library-theme'); // Wordpress core
      wp_dequeue_style('wc-block-style'); // WooCommerce
      wp_dequeue_style('storefront-gutenberg-blocks'); // Storefront theme
    }

    // HTMX
    if ($this->htmx) {
      wp_register_script('htmx', tpf_url() . "lib/htmx-1.9.7/htmx.min.js", [], '1.9.7', true);
      wp_enqueue_script('htmx');
    }

    if (the_project('project_js')) {
      wp_register_script('project_js', tpf_url() . "lib/js/project.js", [], null, true);
      wp_enqueue_script('project_js');
    }

    if (the_project('woo') && the_project('woo_custom_markup')) {
      wp_register_script('woo_js', tpf_url() . "lib/js/woo.js", [], null, true);
      wp_enqueue_script('woo_js');
    }
  }

  // ========================================================= 
  // Custom Routes: Ajax, HTMX 
  // ========================================================= 

  /**
   *  Ajax Route
   *  @example http request to: /ajax/test/ will execute /ajax/test.php
   */
  public function ajax_route() {

    $url = explode("/", $_SERVER['REQUEST_URI']);
    $path = "";

    foreach ($url as $part) $path .= "/$part";
    $path = str_replace('//', '/', $path);
    preg_match('/[\s\S]*?(?=ajax)/', $path, $match);
    $path = str_replace($match, '/', $path);

    if ($url[1] == 'ajax' || (isset($url[2]) && $url[2] == 'ajax')) {

      global $wp_query;

      // remove $_GET variables from path
      $path = strtok($path, '?');

      if ($wp_query->is_404) {
        status_header(200);
        $wp_query->is_404 = false;
      }

      // If is root ajax
      if ($path == "/ajax/") {
        include(tpf_path() . "ajax/readme.php");
        exit();
      }

      $tpf_file = tpf_path() . $path;
      $tpf_file = str_replace("//", "/", $tpf_file);
      $theme_file = get_template_directory() . $path;
      $file = file_exists($theme_file) ? $theme_file : $tpf_file;
      $file = substr($file, 0, -1) . ".php";
      include($file);
      exit();
    }
  }

  public function get_htmx_file() {
    if (!the_project("htmx")) return false;
    if (isset($_GET["htmx"]) && !empty($_GET["htmx"]) && $_GET["htmx"] != "") {
      $layout = sanitize_text_field($_GET["htmx"]);
      $layout = str_replace(".php", "", $layout);
      if (substr($layout, 0, 1) == "/") $layout = substr_replace($layout, "", 0, 1);
      if (substr($layout, -1) == "/") $layout = substr_replace($layout, "", -1);
      $layout_array = explode("/", $layout);
      return $layout;
    }
    return false;
  }

  // ========================================================= 
  // Features and fixes
  // ========================================================= 

  // Add support for svg upload
  public function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }

  // Dont show private menus
  public function filter_private_pages_from_menu($items, $args) {
    foreach ($items as $ix => $obj) {
      if (!is_user_logged_in() && 'private' == get_post_status($obj->object_id)) {
        unset($items[$ix]);
      }
    }
    return $items;
  }

  // Pagination 404 Fix
  function custom_pre_get_posts($query) {
    if ($query->is_main_query() && !$query->is_feed() && !is_admin() && is_category()) {
      $query->set('paged', str_replace('/', '', get_query_var('page')));
    }
  }

  // ========================================================= 
  // Admin Assets
  // ========================================================= 

  public function admin_assets() {
    if (!is_admin()) return;

    $suffix = the_project('dev_mode') == '1' ? time() : '1.0';

    $css_file = tpf_url() . "admin/assets/admin.min.css";
    wp_register_style("the_project_admin_css", $css_file, null, $suffix);
    wp_enqueue_style('the_project_admin_css');

    //$swal = tpf_url() . "lib/sweetalert2/sweetalert2.all.min.js";
    //wp_enqueue_script("rm_script", $swal, false, $suffix);

    //$macy_js = tpf_url() . "lib/macy.js-2.5.1/dist/macy.js";
    //wp_enqueue_script('tpf-macy-js', $macy_js, array('wp-api'));

    $admin_js_path = tpf_url() . "admin/assets/admin.js";
    wp_enqueue_script('tpf-admin-js', $admin_js_path, array('wp-api'));

    $htmx = tpf_url() . "lib/js/htmx.min.js";
    wp_enqueue_script('tpf-htmx', $htmx, array('wp-api'));
  }
}