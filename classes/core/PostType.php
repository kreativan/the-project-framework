<?php

/**
 *  Create Post Type and submenu
 *  under project menu
 *  @author Ivan Milincic <kreativan.dev@gmail.com>
 *  @link http://kraetivan.dev
 */

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class Post_Type {

  public $name;
  public $title;
  public $singular_name;
  public $icon;
  public $menu_position;
  public $submenu_title;
  public $supports;
  public $main_menu_slug;
  public $show_in_menu;

  public function __construct($data = []) {

    // main menu slug
    $this->main_menu_slug = !empty($data['main_menu_slug']) ? $data['main_menu_slug'] : "site-settings";

    $this->name = !empty($data['name']) ? $data['name'] : "";
    $this->title = !empty($data['title']) ? $data['title'] : "";
    $this->singular_name = !empty($data['singular_name']) ? $data['singular_name'] : "";

    $this->icon = !empty($data['icon']) ? $data['icon'] : "superhero";
    $this->menu_position = !empty($data['menu_position']) ? $data['menu_position'] : 3;
    $this->submenu_title = !empty($data['submenu_title']) ? $data['submenu_title'] : "";
    $this->show_in_menu = !empty($data['show_in_menu']) && $data['show_in_menu'] ? $data['show_in_menu'] : false;

    $this->supports = !empty($data['supports']) ? $data['supports'] : ['title'];

    $admin_columns = !empty($data['admin_columns']) ? $data['admin_columns'] : [];

    add_action('init', [$this, 'create_post_type'], 0);
    if (!$this->show_in_menu) add_action('admin_menu', [$this, 'cerate_submenu']);
    new Admin_Columns("{$this->name}", $admin_columns);
  }

  public function create_post_type() {

    $labels = array(
      'name'                  => $this->title,
      'singular_name'         => $this->singular_name,
      'menu_name'             => $this->title,
      'name_admin_bar'        => $this->title,
    );

    $args = array(
      'label'                 => $this->singular_name,
      'labels'                => $labels,
      'supports'              => $this->supports,
      'hierarchical'          => true,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => $this->show_in_menu,
      'menu_position'         => $this->menu_position,
      'menu_icon'             => $this->icon,
      'show_in_admin_bar'     => false,
      'show_in_nav_menus'     => false,
      'can_export'            => true,
      'has_archive'           => false,
      'exclude_from_search'   => true,
      'publicly_queryable'    => false,
      'rewrite'               => false,
      'capability_type'       => 'page',
      'show_in_rest'          => false,
    );

    register_post_type($this->name, $args);
  }

  public function cerate_submenu() {
    if (!$this->show_in_menu) return;
    add_submenu_page(
      $this->main_menu_slug, // main menu slug default: 'project'
      $this->submenu_title, // title
      $this->submenu_title, // menu_title
      'manage_options', // permission
      "edit.php?post_type={$this->name}", // slug 
      null, // callback function
      $this->menu_position,
    );
  }
}
