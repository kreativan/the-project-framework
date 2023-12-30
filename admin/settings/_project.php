<?php

if (!defined('ABSPATH')) {
  exit;
}

$dashicons = file_get_contents(plugin_dir_path(__FILE__) . "../../lib/json/dashicons.json");
$dashicons = json_decode($dashicons, true);
$dashicons_custom_array = [];
foreach ($dashicons as $key => $value) $dashicons_custom_array[$key] = $key;

$project = [
  "name" => [
    "type" => "text",
    "label" =>  "Name",
    "default" => "The Project",
    "description" => "Project title, admin menu title...",
  ],
  "icon" => [
    "type" => "select",
    "label" =>  "Icon",
    "options" => $dashicons_custom_array,
    "default" => "superhero",
    "description" => "Project admin menu title...",
  ],
];

$project_arr['Project'] = $project;
