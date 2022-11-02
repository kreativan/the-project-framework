<?php namespace TPF;
/**
 *  Create Post Type Class
 *  @author Ivan Milincic <kreativan.dev@gmail.com>
 *  @link http://kraetivan.dev
*/

class Post_Type {

  public function __construct($data = []) {

    $this->name = !empty($data['name']) ? $data['name'] : "";
    $this->title = !empty($data['title']) ? $data['title'] : "";
    $this->singular_name = !empty($data['singular_name']) ? $data['singular_name'] : "";

    $this->icon = !empty($data['icon']) ? $data['icon'] : "superhero";
    $this->menu_position = !empty($data['menu_position']) ? $data['menu_position'] : 3;
    $this->submenu_title = !empty($data['submenu_title']) ? $data['submenu_title'] : "";

    $admin_columns = !empty($data['admin_columns']) ? $data['admin_columns'] : [];

    add_action( 'init', [$this, 'create_post_type'], 0 );
    add_action('admin_menu', [$this, 'cerate_submenu']);
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
      'supports'              => array( 'title' ),
      'hierarchical'          => true,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => false,
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
    register_post_type( $this->name, $args );
  }

  public function cerate_submenu() {
    add_submenu_page(
      "project", // main menu slug
      $this->submenu_title, // title
      $this->submenu_title, // menu_title
      'manage_options', // permision
      "edit.php?post_type={$this->name}", // slug 
      null, // callback function
      1,
    );
  }

}