<?php

namespace TPF;

/**
 *  Plugin Name: The Project Framework
 *  Description: Framework for building custom websites
 *  Version: 0.0.1
 *  Author: kreativan.dev
 *  Author URI: http://kreativan.dev/
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

// error_reporting(E_ALL ^ E_NOTICE); 

// Includes
include_once("admin/settings/settings.php");
include_once("functions.php");

tpf_autoload("classes/core");
tpf_autoload("classes/features");
tpf_autoload("classes/utility");
tpf_autoload("functions");

// Init Text Domain
add_action('plugins_loaded', function () {
  load_plugin_textdomain('the-project-framework', false, dirname(plugin_basename(__FILE__)) . '/languages/');
});

/**
 * Init Project
 * - create admin menus
 * - watch for ajax requests
 * - setup ACF site settings
 * - load htmx
 */
new The_Project([

  // Project Title
  "title" => the_project('name') ? the_project('name') : "The Project",

  // gutenberg
  "gutenberg" => 'false',

  // admin menu
  "menu" => "true",

  // Admin menu icon
  "icon" => the_project('icon') ? "dashicons-" . the_project('icon') : 'dashicons-generic',

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

]);

// Create The ProjectSettings
new The_Project_Settings;

// Advanced Custom Fields Init
new ACF();

// SMTP
if (the_project('smtp_enable')) new SMTP();

// --------------------------------------------------------- 
// Features 
// --------------------------------------------------------- 

// Features: SEO
if (the_project('seo')) new SEO();

// Features: ACF Forms
if (the_project('forms'))  new ACF_Forms(true);

// Features: Content Blocks
if (the_project('content_blocks')) new Content_Blocks(true);

// Features: Users
if (the_project('manage_users')) new Users;

// Features: translator
if (the_project('translator')) {

  new Submenu([
    "title" => "Translator",
    "slug" => "translator",
    "view" => "translator",
  ]);

  // Redirect on translator
  if (is_admin() && isset($_GET['tpf_translator_scan'])) {
    add_action('init', function () {
      wp_redirect('./admin.php?page=translator');
    });
  }
}

// --------------------------------------------------------- 
// WooCommerce 
// --------------------------------------------------------- 

if (the_project('woo')) {
  // auto all woo classes
  tpf_autoload("classes/woo");
  // init woo
  new Woo();
}

// --------------------------------------------------------- 
// Actions 
// --------------------------------------------------------- 

do_action('tpf_init');
