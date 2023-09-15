<?php

if (function_exists('acf_add_local_field_group')):

  acf_add_local_field_group(array(
    'key' => 'group_633c39c73ddfa',
    'title' => 'Discounts',
    'fields' => array(
      array(
        'key' => 'field_633c3dd961800',
        'label' => 'Enable',
        'name' => 'enable',
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
        'message' => '',
        'default_value' => 1,
        'ui_on_text' => '',
        'ui_off_text' => '',
        'ui' => 1,
      ),
      array(
        'key' => 'field_633c39c849ce0',
        'label' => 'Percent %',
        'name' => 'percent',
        'aria-label' => '',
        'type' => 'number',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'min' => '',
        'max' => '',
        'placeholder' => '',
        'step' => '',
        'prepend' => '',
        'append' => '',
      ),
      array(
        'key' => 'field_633c3a14cf308',
        'label' => 'User Roles',
        'name' => 'user_roles',
        'aria-label' => '',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'choices' => array(
          'all' => 'All',
          'administrator' => 'Administrator',
          'editor' => 'Editor',
          'author' => 'Author',
          'contributor' => 'Contributor',
          'subscriber' => 'Subscriber',
        ),
        'default_value' => false,
        'return_format' => 'value',
        'multiple' => 0,
        'allow_null' => 0,
        'ui' => 0,
        'ajax' => 0,
        'placeholder' => '',
      ),
      array(
        'key' => 'field_633d3ba57b122',
        'label' => 'Product Category',
        'name' => 'discount_product_category',
        'aria-label' => '',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'choices' => array(
        ),
        'default_value' => array(
        ),
        'return_format' => 'value',
        'multiple' => 1,
        'allow_null' => 0,
        'ui' => 1,
        'ajax' => 0,
        'placeholder' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'project_discounts',
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
    'modified' => 1665403550,
  ));

endif;