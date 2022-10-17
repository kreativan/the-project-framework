<?php
/**
 *  Get Menu items based on wp menu name
 *  @param string $name
 *  @return array; 
 */
function tpf_menu($name) {
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
