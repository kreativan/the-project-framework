<?php

/**
 * Init ACF related Stuff
 * - Init ACF Options Page
 * - Populate ACF fields by name
 */

namespace TPF;

class ACF {

  public function __construct() {

    if (is_admin()) {
      add_filter('acf/load_field/name=user_roles', [$this, 'populate_user_roles']);
      add_filter('acf/load_field/name=select_post_type', [$this, 'populate_post_type']);
      add_filter('acf/load_field/name=pb_style', [$this, 'populate_pb_style']);
      add_filter('acf/load_field/name=pb_space', [$this, 'populate_pb_space']);
      add_filter('acf/load_field/name=pb_grid', [$this, 'populate_pb_grid']);
    }

    if (function_exists('acf_add_local_field_group')) {

      // Options (site settings field group)
      tpf_acf_group_init('options');
    }
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
    $arr = [
      'default' => 'Default',
      'primary' => 'Primary',
      'secondary' => 'Secodnary',
      'muted' => 'Muted',
    ];
    $field['choices'] = $arr;
    return $field;
  }

  public function populate_pb_space($field) {
    $field['choices'] = [];
    $arr = [
      'normal' => 'Normal',
      'small' => 'Small',
      'medium' => 'Medium',
      'large' => 'Large',
      'xlarge' => 'xLarge',
      'no-space' => 'No Space',
    ];
    $field['choices'] = $arr;
    return $field;
  }

  public function populate_pb_grid($field) {
    $field['choices'] = [];
    $arr = [
      'expand' => 'Expand',
      '1-1' => '1',
      '1-2' => '2',
      '1-3' => '3',
      '1-4' => '4',
      '1-5' => '5',
      '1-6' => '6',
    ];
    $field['choices'] = $arr;
    return $field;
  }
}
