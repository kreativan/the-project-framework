<?php

function dump($var) {
  echo '<pre>',print_r($var,1),'</pre>';
}

/**
 * Get tpf plugin directory path
 */
function tpf_dir() {
  return WP_PLUGIN_DIR . "/the-project-framework/";
}

/**
 * Get tpf plugin directory url
 */
function tpf_url() {
  return plugin_dir_url(__DIR__);
}

/**
 * Project info and developer settings
 * @param string $field
 */
function the_project($field = "") {

  $arr = get_option('project_settings');
  
  if($field != "") {
    return isset($arr[$field]) ? $arr[$field] : "";
  } else {
    return $arr;
  }

}

function tpf_settings($field = "") {
  return the_project($field);
}

/**
 * Site settings defined in ACF options
 */
function site_settings($field) {
  if(function_exists("get_field")) {
    $value = get_field("$field", 'options');
    return !empty($value) ? $value : false;
  }
}

function tpf_render($file_name, $args = []) {
  $plugin_dir = WP_PLUGIN_DIR . "/the-project-framework/";
  if(substr($file_name, -4) != ".php") $file_name = $file_name . ".php";
  $layout = $plugin_dir . $file_name;
  include($layout);
}

function tpf_include($file_name, $args = []) {
  if(substr($file_name, -4) != ".php") $file_name = $file_name . ".php";
  $layout = get_template_directory() . "/{$file_name}";
  include($layout);
}

/**
 * Render Form
 */
function tpf_form($id) {
  if (!the_project('forms')) {
    echo "<div class='uk-text-danger'>The Project forms are disabled</div>";
    return false;
  }
  tpf_render("acf-forms/_form", ["id" => $id]);
}