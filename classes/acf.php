<?php namespace TPF;

class ACF {

  public function __construct() {

    if(is_admin()) {
      add_filter('acf/load_field/name=user_roles', [$this, 'populate_user_roles']);
      add_filter('acf/load_field/name=select_svg', 'populate_svg');
      add_filter('acf/load_field/name=svg_select', 'populate_svg');
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

 function populate_svg( $field ) { 
    $tpf = new TPF();
    $field['choices'] = [];
    $array = [""];
    $svg_icons = glob($tpf->svg_dir()."*");
    foreach($svg_icons as $svg) $array[basename($svg)] = basename($svg);
    $field['choices'] = $array;
    return $field;
  }
  

}