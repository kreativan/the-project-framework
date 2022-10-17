<?php

function dump($var) {
  echo '<pre>',print_r($var,1),'</pre>';
}

/**
 * Get tpf plugin directory path
 */
function the_project_dir() {
  return WP_PLUGIN_DIR . "/the-project-framework/";
}

/**
 * Get tpf plugin directory url
 */
function the_project_url() {
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

/**
 * Site settings defined in ACF options
 */
function site_settings($field) {
  $value = get_field("$field", 'options');
  return !empty($value) ? $value : false;
}


/**
 * Check if current route is ajax
 */
function is_project_ajax() {
  $url = explode("/", $_SERVER['REQUEST_URI']);
  if($url[1] == 'ajax') return true;
  return false;
}

/**
 * Render (include) files 
 * With possible override from plugin dir to templates dir
 */
function tpf_render($file_name, $args = []) {
  $plugin_dir = WP_PLUGIN_DIR . "/the-project-framework/";
  if(substr($file_name, -4) != ".php") $file_name = $file_name . ".php";
  $layout = $plugin_dir . $file_name;
  include($layout);
}

/**
 * Render ACF form
 */
function the_project_form($id) {
  if (!the_project('forms')) {
    echo "<div class='uk-text-danger'>The Project forms are disabled</div>";
    return false;
  }
  tpf_render("acf-forms/_form", ["id" => $id]);
}

/**
 * Render ACF form short
 */
function tpf_form($id) {
  the_project_form($id);
}