<?php

/**
 * Ajax readme file
 * when access /ajax/ this file will be executed
 */

$ajax_folder = tpf_path() . "ajax/";

// list all sub-folders
$folders = array_filter(glob($ajax_folder . '*'), 'is_dir');

// we will store our routes here
$routes = [];

// get root url
$root_url = get_site_url();

// Scan each folder and get all files
foreach ($folders as $route) {
  $route_name = basename($route);
  // get all files in this folder
  $files = array_filter(glob($route . '/*'), 'is_file');
  foreach ($files as $file) {
    $file_name = str_replace('.php', '', basename($file));
    $file = str_replace(".php", "", basename($file));
    $routes[$route_name][] = get_site_url() . "/ajax/$route_name/$file_name/";
  }
}

// Return json response
echo jsonResponse([
  "status" => 200,
  "message" => "Ajax end-point",
  // include routes only if admin is logged in
  "routes" => is_user_logged_in() && current_user_can('administrator') ? $routes : [],
]);
