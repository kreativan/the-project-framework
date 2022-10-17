<?php

//-------------------------------------------------------- 
//  Katalog post type
//-------------------------------------------------------- 

$katalog = [
  "name" => "katalog",
  "title" => "Katalog",
  "item_title" => "Katalog Item",
  "slug" => "katalog",
  "menu_position" => 2,
  "menu_icon" => "dashicons-archive",
  "has_archive" => "true",  // post type should have archive page?
  "posts_per_page" => 12,
  "taxonomy" => "true",
  "taxonomy_title" => "Category",
  "taxonomy_name" => "katalog_category",
  "taxonomy_slug" => "katalog-category", // disable this to use /katalog/my-category/ rewrite
  "admin_columns" => [
    'ganre' => 'Ganre',
    // Show thumbnail, basic or with options below....
    // 'thumbnail' => 'Thumbnail',
    'thumbnail' => [
      'label' => 'Thumbnail',
      'width' => 60,
      'height' => 80,
    ],
  ]
];

new The_Project_Post_Type($katalog);

//-------------------------------------------------------- 
//  Forms + submenu
//-------------------------------------------------------- 

new The_Project_Post_Type([
  "name" => "project-forms",
  "title" => 'Forms',
  "item_title" => 'Form',
  "show_in_menu" => "false",
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