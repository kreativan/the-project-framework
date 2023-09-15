<?php

// Navbar dropdown html/css update
class Walker_Navbar extends Walker_Nav_Menu {
  function start_lvl(&$output, $depth = 0, $args = null) {
    $indent = str_repeat("\t", $depth);
    $output .= "<div class='uk-navbar-dropdown'>";
    $output .= "\n$indent<ul class=\"uk-nav uk-navbar-dropdown-nav\">\n";
  }
}

// Navbar dropdown html/css update
class Walker_MobileMenu extends Walker_Nav_Menu {

  function start_lvl(&$output, $depth = 0, $args = null) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"uk-nav-sub\">\n";
  }
}

/**
 *  Get Menu items by menu title or id
 *  @param string $menu - menu title or id
 *  @example tpf_get_menu('Main Menu');
 *  @return object;
 */
function tpf_get_menu($menu) {
  $menu_items = wp_get_nav_menu_items($menu);
  return $menu_items;
}

// ========================================================= 
// Custom Menu 
// ========================================================= 

/**
 * Get custom menu array
 * @param string $name - menu name
 */
function tpf_get_menu_array($name) {

  $menu_items = wp_get_nav_menu_items($name);
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

function tpf_menu_item_array($item) {
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
