<?php
//
// Options
//

add_action('init', 'the_project_init');

function the_project_init() {

  add_theme_support('title-tag');
  add_theme_support('menus');
  add_theme_support('post-thumbnails');
  add_theme_support('widgets');

  if (is_admin()) {
    $suffix = the_project('dev_mode') == '1' ? time() : '1.0';
    $css_file = plugin_dir_url(__FILE__) . "../assets/admin.min.css";
    wp_register_style("the_project_admin_css", $css_file, null, $suffix);
    wp_enqueue_style( 'the_project_admin_css' );
    $swal = plugin_dir_url(__FILE__) . "../lib/sweetalert2/sweetalert2.all.min.js";
    wp_enqueue_script("rm_script", $swal, false, $suffix);
    $admin_js_path = plugin_dir_url(__FILE__) . "../assets/admin.js";
    wp_enqueue_script('tpf-admin-js', $admin_js_path, array('wp-api'));
  }

}

// Init Translations
// load_theme_textdomain('default', get_template_directory());

//  Pagination 404 Fix
// ===========================================================
function custom_pre_get_posts( $query ) {  
  if ( $query->is_main_query() && !$query->is_feed() && !is_admin() && is_category()) {  
    $query->set( 'paged', str_replace( '/', '', get_query_var( 'page' ) ) );  
  }  
} 

add_action('pre_get_posts','custom_pre_get_posts'); 

function the_project_custom_request($query_string ) { 
  if( isset( $query_string['page'] ) ) { 
    if( ''!= $query_string['page'] ) { 
      if( isset( $query_string['name'] ) ) { 
        unset( $query_string['name'] ); 
      } 
    }
  } 
  return $query_string; 
} 

add_filter('request', 'the_project_custom_request');

//  Menu
// ===========================================================