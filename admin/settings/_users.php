<?php

if (!defined('ABSPATH')) {
  exit;
}


$pages = get_posts(['post_type' => 'page']);
$pages_arr = [];
foreach ($pages as $p) $pages_arr[$p->ID] = $p->post_title;

$menus = [];
foreach (wp_get_nav_menus() as $m) $menus[$m->slug] = $m->name;

$users = [
  'manage_users' => [
    "type" => "radio",
    "label" =>  "Users",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "0",
    "description" => "Custom users features, login, register, forgot password...",
  ],
];

if (the_project('manage_users')) {

  $users['user_page'] = [
    "type" => "select",
    "label" =>  "User Page",
    "options" => $pages_arr,
    "description" => "Select page that will be used as user dashboard"
  ];


  $users['user_menu'] = [
    "type" => "select",
    "label" =>  "User Menu",
    "default" => "user-menu",
    "options" => $menus,
    "description" => "Select the menu for user dashboard"
  ];

  $users['lock_user_pages'] = [
    "type" => "radio",
    "label" =>  "Lock User Pages",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "0",
    "description" => "Prevent delete and remove quick actions",
  ];
}

$users_arr['Users'] = $users;
