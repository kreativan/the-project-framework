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
 *  Get Menu items based on wp menu name
 *  @param string $name
 *  @return array; 
 */
function tpf_get_menu($name) {
  $menu_items = wp_get_nav_menu_items($name);
  $array = [];
  foreach($menu_items as $item) {
    $item_arr = [
      'id' => $item->ID,
      'title' => $item->title,
      'href' => $item->url,  
      'object' => $item->object,
      'type' => $item->type,
    ];
    if($item->menu_item_parent) {
      $array[$item->menu_item_parent]["submenu"][] = $item_arr;
    } else {
      $array[$item->ID] = $item_arr;
    }
  }
  return $array;
}
