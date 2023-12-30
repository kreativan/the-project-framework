<?php
if (!defined('ABSPATH')) {
  exit;
}


$seo = [
  "seo" => [
    "type" => "radio",
    "label" =>  "Basic SEO",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "0",
    "description" => "Pages meta title, description, image...",
  ],
];

$features_arr['SEO'] = $seo;

//  Forms
// ===========================================================

$forms = [
  'forms' => [
    "type" => "radio",
    "label" =>  "Forms",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "1",
    "description" => 'Eanble ACF based form builder',
  ],
];

if (the_project("forms")) {
  $forms['protected_forms'] = [
    "type" => "text",
    "label" =>  "Protected Forms",
    'description' => 'Form IDs separated by comma ( , )',
  ];
}

$features_arr['Forms'] = $forms;

//  Content Blocks
// ===========================================================

$content_blocks = [
  'content_blocks' => [
    "type" => "radio",
    "label" =>  "Content Blocks",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "1",
    "description" => "Enable content blocks",
  ],
];

if (the_project("content_blocks")) {
  $content_blocks['content_blocks_lock'] = [
    "type" => "radio",
    "label" =>  "Lock Content Blocks",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "0",
    "description" => "Prevent delete and remove quick actions",
  ];
}

$features_arr['Content Blocks (Globals)'] = $content_blocks;
