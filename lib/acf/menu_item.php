<?php

if (!defined('ABSPATH')) {
  exit;
}

add_action('acf/include_fields', function () {
  if (!function_exists('acf_add_local_field_group')) {
    return;
  }

  acf_add_local_field_group(array(
    'key' => 'group_652d20f872398',
    'title' => 'Menu Items',
    'fields' => array(
      array(
        'key' => 'field_652d20f8a627c',
        'label' => 'Open in New Tab',
        'name' => 'new_tab',
        'aria-label' => '',
        'type' => 'true_false',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'message' => 'Open link i a new tab',
        'default_value' => 0,
        'ui' => 0,
        'ui_on_text' => '',
        'ui_off_text' => '',
      ),
      array(
        'key' => 'field_652d2193c3604',
        'label' => 'Nofollow',
        'name' => 'nofollow',
        'aria-label' => '',
        'type' => 'true_false',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'message' => 'Add link nofollow',
        'default_value' => 0,
        'ui' => 0,
        'ui_on_text' => '',
        'ui_off_text' => '',
      ),
      array(
        'key' => 'field_652d2193c3605',
        'label' => 'HTMX Modal',
        'name' => 'htmx_modal',
        'aria-label' => '',
        'type' => 'true_false',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'message' => 'Open htmx modal',
        'default_value' => 0,
        'ui' => 0,
        'ui_on_text' => '',
        'ui_off_text' => '',
      ),
      array(
        'key' => 'field_652d2193c3606',
        'label' => 'HTMX Link',
        'name' => 'htmx_link',
        'aria-label' => '',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => array(
          array(
            array(
              'field' => 'field_652d2193c3605',
              'operator' => '==',
              'value' => '1',
            ),
          ),
        ),
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'maxlength' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'nav_menu_item',
          'operator' => '==',
          'value' => 'all',
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
});
