<?php namespace TPF;

class ACF {

  public function __construct() {

    if(is_admin()) {
      add_filter('acf/load_field/name=user_roles', [$this, 'populate_user_roles']);
      add_filter('acf/load_field/name=select_post_type', [$this, 'populate_post_type']);
    }

  }

  function populate_user_roles( $field ) { 
    $field['choices'] = [];
    $all = ['all' => 'All'];
    $roles = wp_roles();
    $roles_arr = $roles->role_names;
    $array = array_merge($all, $roles_arr);
    $field['choices'] = $array;
    return $field;
  }

  public function populate_post_type( $field ) {
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

}