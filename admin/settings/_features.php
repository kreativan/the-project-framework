<?php

//  Translator
// ===========================================================

$translator = [
  "translator" => [
    "type" => "radio",
    "label" =>  "Translator",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "1",
    "description" => 'Translate hardcoded strings <code>__x()</code>'
  ],
];

if (the_project("translator")) {
  $translator['translator_plugin_dir_scan'] = [
    "type" => "radio",
    "label" =>  "Scan Plugin Directory",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "1",
    "description" => 'Include plugin folder in searches'
  ];
}

$features_arr['Translator'] = $translator;

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
