<?php

function the_project_acf_user_roles( $field ) { 

  // reset choices
  $field['choices'] = [];
  $all = ['all' => 'All'];

  $roles = wp_roles();
  $roles_arr = $roles->role_names;
  $array = array_merge($all, $roles_arr);
  $field['choices'] = $array;

  return $field;

}

add_filter('acf/load_field/name=user_roles', 'the_project_acf_user_roles');