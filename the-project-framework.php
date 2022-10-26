<?php
/**
 *  Plugin Name: The Project Framework
 *  Description: Framework for building custom websites
 *  Version: 0.0.1
 *  Author: kreativan.dev
 *  Author URI: http://kreativan.dev/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// error_reporting(E_ALL ^ E_NOTICE); 

// Settings
include_once("settings/settings.php");

// Classes
include_once("classes/less-compiler.php"); 
include_once("classes/project.php");
include_once("classes/post-type.php");
include_once("classes/submenu.php");

// Functions
include_once("functions/tpf.php"); 
include_once("functions/utility.php");
include_once("functions/language.php");
include_once("functions/menus.php");
include_once("functions/media.php");
include_once("functions/htmx.php");
include_once("functions/init.php");

// Advanced Custom Fields
include_once("acf/acf-roles-select.php");
include_once("acf/acf-svg-select.php");

//-------------------------------------------------------- 
//  Init Project
//-------------------------------------------------------- 

$js_files = [];
if(the_project('project_js')) $js_files['project_js'] = plugin_dir_url(__FILE__) . "lib/js/project.js"; 
if(the_project('woo_js')) $js_files['woo_js'] = plugin_dir_url(__FILE__) . "lib/js/woo.js"; 

new The_Project([

  // Project Title
  "title" => the_project('name') ? the_project('name') : "The Project",
  
  // gutenberg
  "gutenberg" => 'false',

  // admin menu
  "menu" => "true",

  // Admin menu icon
  "icon" => the_project('icon') ? "dashicons-".the_project('icon') : 'dashicons-superhero',

  /**
   *  ACF Options Page - Site Settings
   *  Menu Title or false (string)
   *  Need to create ACF Options field group and asign it to the Options Page
   */
  'acf_options' => "Site Settings",

  /**
   *  Enable ajax route on front end?
   *  http request on /ajax/my-file/
   *  will call for /my-theme/ajax/my-file.php
   */
  "ajax" => the_project("ajax"),

  /**
   *  Enable htmx route and Load htmx lib
   *  Use /htmx/ route to fetch content
   */
  "htmx" => the_project("htmx"),
  "htmx_version" => "1.8.0",

  // js, css files suffix
  "assets_suffix" => the_project("dev_mode") == "1" ? time() : the_project("assets_suffix"),

  /**
   *  Load JS files on front end
   *  @example ["my_file" => "my_file_url.js"]
   */
  "js" => $js_files,

  /**
   *  Load CSS files on front end
   *  @example ["my_file" => "my_file_url.css"]
   */
  "css" => [],

  /**
   *  WooCommerce
   *  Let plugin handle basic woocommerce stuff
   *  @var string woocommerce: true/false
   *  Enable / Disable default styles
   *  @var string woocommerce_styles: true/false
   */
  "woocommerce" => the_project("woo") == "1" ? "true" : 'false',
  "woocommerce_scripts" => the_project("woo_scripts") ? "true" : "false",
  "woocommerce_styles" => the_project("woo_styles") ? "true" : "false",

]);

//-------------------------------------------------------- 
// Init Project Settings (Developer Settings)
//-------------------------------------------------------- 

new The_Project_Settings;

//-------------------------------------------------------- 
//  WooCommerce
//-------------------------------------------------------- 

if(the_project("woo")) {
  
  include_once("woo/functions.php");
  include_once("acf/acf-product-categories.php");

  if(!the_project("woo_styles")) {
    add_theme_support('woocommerce');
  }

  // Init Discounts
  if(the_project("discounts")) {
    include_once("woo/discounts.php");
    new The_Project_Discounts;
  }

}

//-------------------------------------------------------- 
//  SMTP
//  Enable and set up SMPT from developer settings
//-------------------------------------------------------- 

if(the_project('smtp_enable') == '1') {

  add_action( 'phpmailer_init', 'the_project_SMTP' );

  function the_project_SMTP($phpmailer) {

    $from_email = the_project('smtp_from_email');
    $from_name = the_project('smtp_from_name');

    $phpmailer->IsSMTP();
    $phpmailer->SetFrom($from_email, $from_name);
    $phpmailer->Host = the_project('smtp_host');
    $phpmailer->Port = the_project('smtp_port');
    $phpmailer->SMTPAuth = true;
    $phpmailer->SMTPSecure = the_project('smtp_secure');
    $phpmailer->Username = the_project('smtp_username');
    $phpmailer->Password = the_project('smtp_password');

  }

}

//-------------------------------------------------------- 
//  Forms
//-------------------------------------------------------- 

if(the_project('forms')) {

  include_once("acf-forms/_submit.php");
  add_action('after_setup_theme', 'acf_form_submit');

  new The_Project_Post_Type([
    "name" => "project-forms",
    "title" => 'Forms',
    "item_title" => 'Form',
    "show_in_menu" => "false",
    "show_in_nav_menus" => "false",
    "menu_position" => 1,
    "menu_icon" => 'dashicons-feedback',
    "hierarchical" => "true", // true=pages, false=posts
    "exclude_from_search" => "true",
    "supports" => ['title'],
    "has_archive" => "false",
    "taxonomy" => "false",
    "admin_columns" => [
      'id' => 'ID',
      'acf_form_code' => 'Function',
    ],
  ]);
  
  new The_Project_Sub_Menu([
    "title" => __('Forms'),
    "slug" => "edit.php?post_type=project-forms"
  ]);

}

//-------------------------------------------------------- 
//  Translations
//-------------------------------------------------------- 

if(the_project('translations')) {
  new The_Project_Sub_Menu([
    "title" => "Translate",
    "slug" => "project-translate",
    "view" => "translate",
  ]);
}
