<?php

if (!defined('ABSPATH')) {
  exit;
}

function dump($var) {
  echo '<pre>', print_r($var, 1), '</pre>';
}

// --------------------------------------------------------- 
// Basic 
// --------------------------------------------------------- 

/**
 * Get tpf plugin directory path
 */
function tpf_dir() {
  return WP_PLUGIN_DIR . "/the-project-framework/";
}

// same as tpf_dir()
function tpf_path() {
  return tpf_dir();
}

/**
 * Get tpf plugin directory url
 */
function tpf_url() {
  return plugin_dir_url(__DIR__) . "the-project-framework/";
}

// same as tpf_url()
function tpf_uri() {
  return tpf_url();
}

/**
 * Get base ajax url
 */
function TPF_Ajax_Url() {
  $ajax_url = get_home_url(null, '', 'relative') . "/ajax/";
  $ajax_url = str_replace('//', '/', $ajax_url);
  return $ajax_url;
}


/**
 * Project info and developer settings
 * Can also display any settings from a wordpress
 * @param string $field - custom option or wp general settings field name
 */
function the_project($field = "") {

  // Custom Options
  $arr = get_option('project_settings');

  if ($field != "") {
    return isset($arr[$field]) ? $arr[$field] : "";
  } else {
    return $arr;
  }
}

// same as the_project()
function tpf_settings($field = "") {
  return the_project($field);
}

/**
 * Site settings defined in ACF options
 */
function site_settings($field = "") {

  // All Custom Site Settings
  $site_settings = get_fields('options');
  $site_settings = !empty($site_settings) ? $site_settings : [];

  // Map site_name = name
  $field = ($field == "site_name") ? "name" : $field;

  // Global Settings
  $general_settings = [
    "name",
    'description',
    'wpurl',
    'url',
    'admin_email',
    'language',
    'stylesheet_url',
    'stylesheet_directory',
    'template_url',
  ];

  // Add General Settings to the array
  foreach ($general_settings as $key) {
    $site_settings[$key] = get_bloginfo($key);
  }

  // if no $field return all settings
  if ($field == "") return $site_settings;

  if (function_exists("get_field")) {
    // $value = get_field("$field", 'options');
    $value = isset($site_settings[$field]) ? $site_settings[$field] : "";
    return !empty($value) ? $value : false;
  }
}

/**
 * Get site language
 * @return string
 */
function site_lang() {
  if (defined('ICL_LANGUAGE_CODE')) {
    $lang = ICL_LANGUAGE_CODE;
  } else {
    $lang = get_option('WPLANG');
    $lang = explode("_", $lang);
    $lang = $lang[0];
  }
  $lang = !empty($lang) ? $lang : 'en';
  return $lang;
}

// --------------------------------------------------------- 
// Render 
// --------------------------------------------------------- 

/**
 * Render File
 * relative to the templates folder
 * Expose passed variables ($args) directly $$key = $value
 */
function render($file_name, $args = []) {
  if ($file_name[0] == "/") $file_name = substr($file_name, 1);
  if (substr($file_name, -1) == "/") $file_name = substr($file_name, 0, -1);
  if (substr($file_name, -4) != ".php") $file_name = $file_name . ".php";
  $tpf_file = tpf_dir() . "{$file_name}";
  $tmpl_file = get_template_directory() . "/{$file_name}";
  $layout = file_exists($tmpl_file) ? $tmpl_file : $tpf_file;
  if (!file_exists($layout)) {
    if (the_project('dev_mode') == '1') {
      echo "<div class='uk-alert uk-alert-danger'>'File $layout does not exists'</div>";
    }
    return;
  }
  foreach ($args as $key => $value) $$key = $value;
  include($layout);
}

/**
 * Include file from TPF folder
 * Expose passed variables ($args) directly $$key = $value
 */
function tpf_include($file_name, $args = []) {
  $dir = WP_PLUGIN_DIR . "/the-project-framework/";
  $file = "{$dir}{$file_name}.php";
  $file = str_replace('//', '/', $file);
  $file = str_replace(".php.php", ".php", $file);
  foreach ($args as $key => $value) $$key = $value;
  if (file_exists($file)) include($file);
}

// --------------------------------------------------------- 
// Helpers 
// --------------------------------------------------------- 

/**
 * Init local acf field group
 * by including file from template or tpf folder.
 * Local field groups are saved as json files in lib/acf/ and theme/assets/acf/ folders
 */
function TPF_ACF_Group_Init($file_name) {
  if (substr($file_name, -4) != ".php") $file_name = $file_name . ".php";
  $tmpl = get_template_directory() . "/assets/acf/$file_name";
  $plg = tpf_path() . "lib/acf/$file_name";
  $file = file_exists($tmpl) ? $tmpl : $plg;
  include_once($file);
}

/**
 * Autoloader
 * Include all files froma  specified folder
 */
function TPF_Autoload($dir) {
  $path = __DIR__ . "/{$dir}/";
  $path = str_replace('//', '/', $path);
  $files = glob("{$path}*.php");
  foreach ($files as $file) {
    // if file name starts with _ skip it
    if (substr(basename($file), 0, 1) != "_") {
      include_once($file);
    }
  }
}


// --------------------------------------------------------- 
// Assets 
// --------------------------------------------------------- 

// Array of js variables
function TPF_JS_Vars() {
  $dev_mode = the_project('dev_mode') == '1' ? true : false;
  $arr = [
    "debug" => $dev_mode ? true : false,
    "ajaxUrl" => tpf_ajax_url(),
  ];
  return $arr;
}

function TPF_Less_Files($theme = "minimal", $arr = []) {
  $array = [];
  $array[] = tpf_path() . "lib/uikit/src/less/uikit.less";
  $array[] = tpf_path() . "lib/less/$theme.less";
  if (the_project('woo')) {
    $array[] = tpf_path() . "lib/less/woocommerce.less";
  }
  $array = array_merge($array, $arr);
  // get wordpress theme less files
  $theme_dir = get_template_directory() . "/assets/less/";
  // get all the files from the directory except the ones starting with _
  $files = glob("{$theme_dir}[!_]*.less");
  foreach ($files as $file) {
    $array[] = $file;
  }
  return $array;
}

function TPF_JS_Files() {
  $array = [
    tpf_url() . "lib/uikit/dist/js/uikit-core.min.js",
    tpf_url() . "lib/uikit/dist/js/uikit-icons.min.js",
    tpf_url() . "lib/uikit/dist/js/components/notification.min.js",
    tpf_url() . "lib/uikit/dist/js/components/lightbox.min.js",
  ];
  return $array;
}
