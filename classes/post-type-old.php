<?php namespace TPF;
/**
 *  Create Post Type Class
 *  @author Ivan Milincic <kreativan.dev@gmail.com>
 *  @link http://kraetivan.dev
*/

class The_Project_Post_Type {


  public function __construct($data = []) {

    // posts
    $this->name = $data['name']; // my_type
    $this->title = $data['title']; // My Type
    $this->item_title = $data['item_title'];
    $this->slug = !empty($data['slug']) ? $data['slug'] : false; // my-slug
    $this->public = !empty($data["public"]) && $data["public"] == "false" ? false : true;
    $this->exclude_from_search = !empty($data['exclude_from_search']) ? $data['exclude_from_search'] : false;
    $this->show_in_menu = !empty($data["show_in_menu"]) && $data["show_in_menu"] == "false" ? false : true;
    $this->show_in_nav_menus = !empty($data["show_in_nav_menus"]) && $data["show_in_nav_menus"] == "false" ? false : true;
    $this->menu_position = !empty($data['menu_position']) ? $data['menu_position'] : 2;
    $this->hierarchical = !empty($data['hierarchical']) && $data['hierarchical'] == false ? false : true;
    $this->menu_icon = !empty($data['menu_icon']) ? $data['menu_icon'] : "dashicons-archive";
    $this->supports = !empty($data['supports']) ? $data['supports'] : ['title', 'editor', 'thumbnail'];
    $this->has_archive = !empty($data["has_archive"]) && $data["has_archive"] == "false" ? false : true;
    $this->taxonomy = !empty($data["taxonomy"]) && $data["taxonomy"] == "false" ? false : true;
    $this->posts_per_page = !empty($data['posts_per_page']) ? $data['posts_per_page'] : 12;
    $this->gutenberg = !empty($data["gutenberg"]) && $data["gutenberg"] == 'false' ? false : true;

    // Taxonomy
    $this->taxonomy_title = !empty($data["taxonomy_title"]) ? $data["taxonomy_title"] : "";
    $this->taxonomy_name = !empty($data["taxonomy_name"]) ? $data["taxonomy_name"] : "";
    $this->taxonomy_singular = !empty($data["taxonomy_singular"]) ? $data["taxonomy_singular"] : "";
    $this->taxonomy_admin_column = !empty($data["taxonomy_admin_column"]) && $data["taxonomy_admin_column"] == "false" ? false : true;
    $this->taxonomy_slug = !empty($data["taxonomy_slug"]) ? $data["taxonomy_slug"] : "";

    // actions
    add_action('init', [$this, 'post_type']);

    // Taxonomy Init
    if($this->taxonomy) {
      add_action('init', [$this, 'taxonomy']);
      add_action('pre_get_posts', [$this, 'posts_per_page']);
      // run rewrite method if taxonomy slug is missing
      if(!$this->taxonomy_slug) {
        add_filter('post_type_link', [$this, 'rewrite_func'], 1, 2);
      }
    }

    // Admin Columns
    $admin_columns = !empty($data['admin_columns']) && count($data['admin_columns']) > 0 ? $data['admin_columns'] : false;
    $this->admin_columns = $admin_columns;

    if($admin_columns) {
      $this->add_admin_column();
    }

  }


  //
  //  Post Type
  //
  public function post_type() {

    $args = [
      "labels" => [
        'name' => $this->title,
        'singular_name' => $this->item_title,
      ],
      "show_in_menu" => $this->show_in_menu,
      "show_in_nav_menus" => $this->show_in_nav_menus,
      "menu_position" => $this->menu_position,
      "hierarchical" => $this->hierarchical, // true=pages, false=posts
      "menu_icon" => $this->menu_icon,
      "public" => $this->public,
      "supports" => $this->supports,
      "has_archive" => $this->has_archive ?  $this->slug : false, // POST_TYPE_SLUG
      "exclude_from_search" => $this->exclude_from_search,
      "show_in_rest" => $this->gutenberg,
    ];

    /**
     *  If taxonomy slug is not defined
     *  rewrite categorys as  /post_type_slug/taxonomy_name/
     */
    if($this->taxonomy && !$this->taxonomy_slug) {
      $slug = $this->name != $this->slug ? $this->slug : $this->name;
      $rewrite_slug = "{$slug}/%{$this->taxonomy_name}%";
      $args['rewrite'] = ["slug" => "$rewrite_slug", 'with_front' => false];
    } elseif($this->name != $this->slug) {
      $args['rewrite'] = ["slug" => "$this->slug", 'with_front' => false];
    }

    register_post_type("{$this->name}", $args);

  }


  //
  //  taxonomy
  //
  public function taxonomy() {

    $taxonomy_slug = $this->taxonomy_slug != "" ? $this->taxonomy_slug : $this->slug;

    $args = [
      "labels" => [
        'name' => $this->taxonomy_title,
        'singular_name' => $this->taxonomy_singular,
      ],
      'show_admin_column' => $this->taxonomy_admin_column,
      "public" => true,
      "hierarchical" => true,
      "rewrite" => ["slug" => "{$taxonomy_slug}", 'with_front' => false], 
    ];

    register_taxonomy("$this->taxonomy_name", ["{$this->name}"], $args);

  }

  // set posts per page
  public function posts_per_page($query) {
    if ( !is_admin() && $query->is_main_query() && is_post_type_archive("{$this->name}") ) {
      $items_per_page = $this->posts_per_page;
      $query->set('posts_per_page', $items_per_page);
    }
    if ($this->taxonomy && !is_admin() && $query->is_main_query() && $query->is_tax("$this->taxonomy_name")) {
      $items_per_page = $this->posts_per_page;
      $query->set('posts_per_page', $items_per_page);
    }
  }


  /**
   *  Rewrite katalog urls
   *  @example /post-type-slub/item-slug/
   */
  public function rewrite_func($post_link, $post) {
    if ( is_object( $post ) && $post->post_type == $this->name) {
      $terms = wp_get_object_terms( $post->ID, $this->taxonomy_name);
      if($terms && !empty($this->taxonomy_name)) {
        return str_replace( "%{$this->taxonomy_name}%" , $terms[0]->slug , $post_link );
      } else {
        return str_replace( "%{$this->taxonomy_name}%" , 'all' , $post_link );
      }
    }
    return $post_link;
  }

  /**
   *  Admin Columns
   *  On post edit page
   */

  // add columns
  public function add_admin_column() {

    // Column Header
    add_filter( 'manage_' . $this->name . '_posts_columns', function($columns) {
      foreach($this->admin_columns as $key => $val) {
        if($key == 'thumbnail') {
          $label = isset($val['label']) ? $val['label'] : $val;
          $columns[$key] = $label;
        } else {
          $columns[$key] = $val;
        }
      }
      return $columns;
    });

    // Column Content
    add_action( 'manage_' . $this->name . '_posts_custom_column' , function($column, $post_id) {
      foreach($this->admin_columns as $key => $val) {
        if($key === $column && $key == 'thumbnail') {
          $w = isset($val['width']) ? $val['width'] : 60;
          $h = isset($val['height']) ? $val['height'] : 60;
          $thumbnail = get_the_post_thumbnail( $post_id, array($w, $h) );
          echo $thumbnail;
        } elseif ($key === $column && $key == 'id') {
          echo $post_id;
        } elseif ($key === $column && $key == 'acf_form_code') {
          echo htmlspecialchars("the_project_form($post_id)");
        } elseif ($key === $column) {
          $this->add_admin_column_cb($post_id, $key);
        }
      }
    }, 10, 2 );

    // Column sort
    add_filter( "manage_edit-{$this->name}_sortable_columns", function ($columns) {
      foreach($this->admin_columns as $key => $val) $columns[$key] = $key;
      return $columns;
    });

  }

  // column callback
  public function add_admin_column_cb($post_id, $field_name) {
    $meta = get_post_meta( $post_id , $field_name , true );
    $out = "";
    if(is_array($meta)) {
      foreach($meta as $part) $out .= "$part<br />";
      echo $out;
    } else {
      echo $meta;
    }
  }


}