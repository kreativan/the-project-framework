<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 *  Get Menu items by menu title or id
 *  @param string $menu - menu title or id
 *  @example tpf_get_menu('Main Menu');
 *  @return object;
 */
function TPF_Get_Menu($menu) {
  $menu_items = wp_get_nav_menu_items($menu);
  return $menu_items;
}

// ========================================================= 
// Custom Menu 
// ========================================================= 

/**
 * Get custom menu array
 * @param string $selector - menu name or id
 */
function TPF_Get_Menu_Array($selector) {

  $menu_items = wp_get_nav_menu_items($selector);
  if (empty($menu_items)) return;

  $array = [];
  $root = [];
  $submenus = [];

  // Root
  foreach ($menu_items as $item) {
    if ($item->menu_item_parent == 0) {
      $root[$item->ID] = tpf_menu_item_array($item);
    }
  }

  // Submenu
  foreach ($menu_items as $item) {
    if ($item->menu_item_parent && isset($root[$item->menu_item_parent])) {
      $submenus[$item->ID] = tpf_menu_item_array($item);
    }
  }

  // Submenu lvl 3
  foreach ($menu_items as $item) {
    if ($item->menu_item_parent && isset($submenus[$item->menu_item_parent])) {
      $submenus[$item->menu_item_parent]['submenu'][] = tpf_menu_item_array($item);
    }
  }

  if (count($root) > 0) {
    foreach ($root as $menu) {
      $key = $menu['id'];
      $array[$key] = $menu;
    }
  }

  if (count($submenus) > 0) {
    foreach ($submenus as $menu) {
      $key = $menu['parent'];
      $array[$key]['submenu'][] = $menu;
    }
  }

  return $array;
}

function TPF_Menu_item_Array($item) {
  $item_arr = [
    'id' => $item->ID,
    'title' => $item->title,
    'href' => $item->url,
    'object' => $item->object,
    'type' => $item->type,
    'parent' => $item->menu_item_parent,
    'target' => $item->target,
    'attr_title' => $item->attr_title,
    "classes" => $item->classes,
    'submenu' => [],
  ];
  return $item_arr;
}
