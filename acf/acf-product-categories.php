<?php

if(is_admin()) {

  function the_project_acf_product_categories( $field ) { 

    // reset choices
    $field['choices'] = [];
    $array = [];

    $categories = get_terms( ['taxonomy' => 'product_cat'] );
    foreach($categories as $cat) {
      $array[$cat->slug] = $cat->name;
    }
    $field['choices'] = $array;

    return $field;

  }

  add_filter('acf/load_field/name=discount_product_category', 'the_project_acf_product_categories');

}