<?php
/**
 *  Project Menu Class
 *  @author Ivan Milincic <kreativan.dev@gmail.com>
 *  @link http://kraetivan.dev
 */

class The_Project_Sub_Menu {

  public function __construct($data) {

    $this->title = !empty($data["title"]) ? $data["title"] : ""; 
    $this->slug = !empty($data["slug"]) ? $data["slug"] : "";
    $this->view = !empty($data["view"]) ? $data["view"] : "";
    $this->parent = !empty($data["parent"]) ? $data["parent"] : "project";
    $this->position = !empty($data["position"]) ? $data["position"] : null;
    $this->plugin =  !empty($data["plugin"]) ? $data["plugin"] : 'the-project-framework';

    add_action('admin_menu', [$this, 'add_project_menu']);

  }


  public function add_project_menu() {

    $callback = ($this->view != "") ? [$this, "project_menu_callback"] : "";

    add_submenu_page(
      $this->parent, // main menu slug
      $this->title, // title
      $this->title, // menu_title
      'manage_options', // permision
      $this->slug, // slug 
      $callback, // callback function
      $this->position,
    );

  }

  public function project_menu_callback() {
    $view_file = WP_PLUGIN_DIR ."/{$this->plugin}/views/{$this->view}.php";
    if($this->view != "" && file_exists($view_file)) include($view_file);
  }


}