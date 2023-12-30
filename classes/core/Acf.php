<?php

/**
 * Init ACF related Stuff
 * - Init ACF Options Page
 * - Populate ACF fields by name
 */

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class ACF {

  public function __construct() {

    if (is_admin()) {
      add_filter('acf/fields/flexible_content/layout_title/name=page_builder', [$this, 'page_builder_labels'], 10, 4);
      add_filter('acf/load_field/name=user_roles', [$this, 'populate_user_roles']);
      add_filter('acf/load_field/name=select_post_type', [$this, 'populate_post_type']);
      add_filter('acf/load_field/name=pb_style', [$this, 'populate_pb_style']);
      add_filter('acf/load_field/name=pb_space', [$this, 'populate_pb_space']);
      add_filter('acf/load_field/name=pb_grid', [$this, 'populate_pb_grid']);
    }

    if (function_exists('acf_add_local_field_group')) {
      // Options (site settings field group)
      TPF_ACF_Group_Init('options');

      // Menu Items
      TPF_ACF_Group_Init('menu_item');
    }
  }

  //-------------------------------------------------------- 
  //  Flexible Field
  //--------------------------------------------------------

  /**
   * Set layout labels based on the title or headline fields
   */
  public function page_builder_labels($title, $field, $layout, $i) {

    $subfield_title = get_sub_field("title");
    $subfield_headline = get_sub_field("headline");
    $subfield_enable = get_sub_field("enable");

    if ($subfield_title && !empty($subfield_title)) {
      $title =  $title . " - " . $subfield_title;
    } elseif ($subfield_headline && !empty($subfield_headline)) {
      $title = $title . " - " . $subfield_headline;
    }

    if (!$subfield_enable) {
      $title .= " - <span style='color: #f87171;'>(DISABLED)</span>";
    }

    return $title;
  }

  //-------------------------------------------------------- 
  //  Fields
  //--------------------------------------------------------  

  public function populate_user_roles($field) {
    $field['choices'] = [];
    $all = ['all' => 'All'];
    $roles = wp_roles();
    $roles_arr = $roles->role_names;
    $array = array_merge($all, $roles_arr);
    $field['choices'] = $array;
    return $field;
  }


  public function populate_post_type($field) {
    $field['choices'] = [];
    $args = array(
      'public'   => true,
      '_builtin' => false,
    );
    $post_types = get_post_types($args);
    unset($post_types['project-forms']);
    $field['choices'] = $post_types;
    return $field;
  }

  public function populate_pb_style($field) {
    $field['choices'] = [];
    $lib_file = tpf_dir() . "lib/json/pb_style.json";
    $tmpl_file = get_template_directory() . '/assets/json/pb_style.json';
    $json_file = file_exists($tmpl_file) ? $tmpl_file : $lib_file;
    $arr = json_decode(file_get_contents($json_file), true);
    $field['choices'] = $arr;
    return $field;
  }

  public function populate_pb_space($field) {
    $field['choices'] = [];
    $lib_file = tpf_dir() . "lib/json/pb_space.json";
    $tmpl_file = get_template_directory() . '/assets/json/pb_space.json';
    $json_file = file_exists($tmpl_file) ? $tmpl_file : $lib_file;
    $arr = json_decode(file_get_contents($json_file), true);
    $field['choices'] = $arr;
    return $field;
  }

  public function populate_pb_grid($field) {
    $field['choices'] = [];
    $$lib_file = tpf_dir() . "lib/json/pb_grid.json";
    $tmpl_file = get_template_directory() . '/assets/json/pb_grid.json';
    $json_file = file_exists($tmpl_file) ? $tmpl_file : $lib_file;
    $arr = json_decode(file_get_contents($json_file), true);
    $field['choices'] = $arr;
    return $field;
  }
}
