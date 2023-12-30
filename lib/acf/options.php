<?php

if (!defined('ABSPATH')) {
  exit;
}

if (function_exists('acf_add_local_field_group')) :

  acf_add_local_field_group(array(
    'key' => 'group_625e863915bca',
    'title' => 'Options',
    'fields' => array(
      array(
        'key' => 'field_625e86e3780b3',
        'label' => 'Logo',
        'name' => 'logo',
        'aria-label' => '',
        'type' => 'image',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '50',
          'class' => '',
          'id' => '',
        ),
        'return_format' => 'array',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => '',
        'preview_size' => 'thumbnail',
      ),
      array(
        'key' => 'field_63772718cca4c',
        'label' => 'Favicon',
        'name' => 'favicon',
        'aria-label' => '',
        'type' => 'image',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '50',
          'class' => '',
          'id' => '',
        ),
        'return_format' => 'array',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => 'png',
        'preview_size' => 'thumbnail',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'options_page',
          'operator' => '==',
          'value' => 'site-settings',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
  ));

endif;
