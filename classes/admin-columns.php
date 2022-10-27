<?php

class The_Project_Admin_Columns {


  public function __construct($post_type, $data = []) {

    $this->post_type = isset($post_type) ? $post_type : false;
    $this->data = $data;

    $this->init_admin_columns();

  }

  public function init_admin_columns() {
    add_filter("manage_{$this->post_type}_posts_columns", [$this, 'admin_columns_label']); 
    add_action("manage_{$this->post_type}_posts_custom_column", [$this, 'admin_columns_data'], 10, 2);
    add_filter("manage_edit-{$this->post_type}_sortable_columns", [$this, 'admin_columns_sort']);
  }

  public function admin_columns_label($columns) {
    $columns = [
      'cb' => $columns['cb'],
      'title' => __( 'Title' ),
    ];
    foreach($this->data as $key => $value) {
      $columns["$key"] = $value;
    }
    return $columns;
  }

  public function admin_columns_data($column, $post_id) {
    foreach($this->data as $key => $value) {
      if($column === $key) echo get_post_meta($post_id, $key, true);
    }
  }

  public function admin_columns_sort($columns) {
    foreach($this->data as $key => $value) $columns["$key"] = $key;
    return $columns;
  }


}