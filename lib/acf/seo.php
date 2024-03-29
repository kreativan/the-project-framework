<?php

if (!defined('ABSPATH')) {
  exit;
}

if (function_exists('acf_add_local_field_group')) :

  acf_add_local_field_group(array(
    'key' => 'group_62d6b7788913b',
    'title' => 'SEO',
    'fields' => array(
      array(
        'key' => 'field_62d6b77fddffb',
        'label' => 'Seo Title',
        'name' => 'seo_title',
        'aria-label' => '',
        'type' => 'textarea',
        'instructions' => 'You can use fields from the site settings eg: {name}, {description}',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
        'rows' => 2,
      ),
      array(
        'key' => 'field_62d6b78bddffc',
        'label' => 'Seo Description',
        'name' => 'seo_description',
        'aria-label' => '',
        'type' => 'textarea',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => '',
        'rows' => 5,
        'new_lines' => '',
      ),
      array(
        'key' => 'field_62d6b792ddffd',
        'label' => 'Seo Image',
        'name' => 'seo_image',
        'aria-label' => '',
        'type' => 'image',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'return_format' => 'array',
        'preview_size' => 'thumbnail',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'page',
        ),
        array(
          'param' => 'page',
          'operator' => '!=',
          'value' => tpf_user_page('ID'),
        ),
        array(
          'param' => 'page_parent',
          'operator' => '!=',
          'value' => tpf_user_page('ID'),
        ),
      ),
    ),
    'menu_order' => 99,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
    'modified' => 1665666755,
  ));

endif;
