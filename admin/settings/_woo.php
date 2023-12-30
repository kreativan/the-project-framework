<?php

if (!defined('ABSPATH')) {
  exit;
}


$woo = [
  "woo" => [
    "type" => "radio",
    "label" =>  "WooCommerce",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "0",
    "description" => "Enable WooCommerce Support",
  ],
  "woo_custom" => [
    "type" => "radio",
    "label" =>  "Customizations",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "hidden" => the_project("woo") ? 1 : 0,
    "default" => 1,
    "description" => "Enable WooCommerce Customizations",
  ],
];

$discounts = [
  'discounts' => [
    "type" => "radio",
    "label" =>  "Discounts",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "0",
    "description" => "Enable discounts for WooCommerce",
  ],
];

$search_filters = [
  'search_filters' => [
    "type" => "radio",
    "label" =>  "Search Filters",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "0",
    "description" => "Enable search filters for WooCommerce",
  ],
];

$woo_arr['WooCommerce'] = $woo;
$woo_arr['Discounts'] = $discounts;
$woo_arr['Search Filters'] = $search_filters;
