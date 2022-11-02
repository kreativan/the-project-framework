<?php namespace TPF;

class Admin_Columns {


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
    
    $columns = ['cb' => $columns['cb']];

    if( isset($this->data['thumb']) ) {
      $columns['thumb'] = __( 'Image' );
    }

    $columns['title'] = __( 'Title' );

    foreach($this->data as $key => $value) {
      $columns["$key"] = $value;
    }

    return $columns;

  }

  public function admin_columns_data($column, $post_id) {
    foreach($this->data as $key => $value) {
      if($column === "id") {
        echo $post_id;
      }elseif($column === $key) {
        $post_data = get_post_meta($post_id, $key, true);
        if(is_array($post_data)) {
          $str = "";
          foreach($post_data as $item) $str .= "$item<br />";
          echo $str;
        } else {
          echo $post_data;
        }
      }
    }
  }

  public function admin_columns_sort($columns) {
    foreach($this->data as $key => $value) $columns["$key"] = $key;
    return $columns;
  }


}