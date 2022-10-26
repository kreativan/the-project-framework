<?php
function tpf_acf_select_svg( $field ) { 

  // reset choices
  $field['choices'] = [];

  $array = [""];
  $svg_icons = glob(tpf_svg_dir()."*");
  foreach($svg_icons as $svg) $array[basename($svg)] = basename($svg);
  $field['choices'] = $array;

  return $field;

}

add_filter('acf/load_field/name=select_svg', 'tpf_acf_select_svg');
add_filter('acf/load_field/name=svg_select', 'tpf_acf_select_svg');