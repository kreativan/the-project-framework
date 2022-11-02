<?php namespace TPF;
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
include_once("classes/tpf.php");
include_once("classes/acf.php");

include_once("classes/utility.php");
include_once("classes/less-compiler.php"); 
include_once("classes/project.php");
include_once("classes/post-type.php");
include_once("classes/admin-columns.php");
include_once("classes/submenu.php");
include_once("classes/form.php");

// Functions
include_once("functions/tpf.php"); 
include_once("functions/language.php");
include_once("functions/menus.php");
include_once("functions/init.php");

// TPF object
$tpf = new \TPF();

$js_files = [];
if(the_project('tpf_js')) $js_files['tpf_js'] = plugin_dir_url(__FILE__) . "lib/js/tpf.js"; 
if(the_project('woo_js')) $js_files['woo_js'] = plugin_dir_url(__FILE__) . "lib/js/woo.js"; 


/**
 * Init Project
 *
 */
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

// Create The ProjectSettings
new The_Project_Settings;

// Advanced Custom Fields Utilities
new ACF();

// SMTP
if($tpf->settings('smtp_enable')) {
  include_once("addons/smtp.php");
  new SMTP();
}

// ACF Based Forms
if($tpf->settings('forms')) {
  include_once("addons/acf-forms.php");
  new ACF_Forms(true);
}

// Translations
if($tpf->settings('translations')) {
  new Submenu([
    "title" => "Translate",
    "slug" => "project-translate",
    "view" => "translate",
  ]);
}

// WooCommerce
if($tpf->settings('woo')) {

  include_once("addons/woo.php");
  include_once("addons/discounts.php");

  new Woo;

  if($tpf->settings('discounts')) {
    new Discounts;
  }

}