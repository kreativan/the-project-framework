<?php

/**
 * Admin Columns
 */

namespace TPF;

class Admin_Columns {


  public function __construct($post_type, $data = []) {

    $this->post_type = isset($post_type) ? $post_type : false;
    $this->data = $data;

    $this->init_admin_columns();

    add_action('admin_head', [$this, 'admin_column_style']);
  }

  public function init_admin_columns() {
    add_filter("manage_{$this->post_type}_posts_columns", [$this, 'admin_columns_label']);
    add_action("manage_{$this->post_type}_posts_custom_column", [$this, 'admin_columns_data'], 10, 2);
    add_filter("manage_edit-{$this->post_type}_sortable_columns", [$this, 'admin_columns_sort']);
  }

  public function admin_columns_label($columns) {

    $columns = ['cb' => $columns['cb']];

    /** 
     * Add thumb first 
     */
    if (isset($this->data['thumb'])) {
      $columns['thumbnail'] = __('Thumbnail');
    }


    /** 
     * If any column label is thumb Thumbnail...
     * add it first 
     */
    $thumb_array = ['thumb', 'Thumb', 'thumbnail', 'Thumbnail'];
    foreach ($this->data as $key => $value) {
      if (in_array($value, $thumb_array)) $columns["$key"] = '<span class="dashicons dashicons-cover-image" style="margin-left:10px;"></span>';
    }


    /** Title */
    $columns['title'] = __('Title');

    foreach ($this->data as $key => $value) {
      if (!in_array($value, $thumb_array) && !in_array($key, $thumb_array)) $columns["$key"] = $value;
    }

    return $columns;
  }

  public function admin_columns_data($column, $post_id) {

    $keys_arr = [];
    $keys = array_keys($this->data);
    foreach ($keys as $key) $keys_arr[$key] = $key;
    $field_name = isset($keys_arr[$column]) ? $keys_arr[$column] : '';

    if ($column == "id") {

      echo $post_id;
    } elseif ($column == "thumbnail") {

      echo get_the_post_thumbnail($post_id);
    } elseif ($column == "image" || $column == "background" || $column == "bg" || $column == "img") {

      $image = get_field($field_name, $post_id);
      if ($image) {
        $src = $image['sizes']['thumbnail'];
        echo "<img src='$src' width='44' height='44' />";
      } else {
        echo "<div style='display: flex; align-items: center; justify-content: center;width: 44px;height: 44px;background: #f8f8f8;'><span class='dashicons dashicons-format-image' style='color: #aaa'></span></div>";
      }
    } else {

      $post_data = get_post_meta($post_id, $field_name, true);

      if (is_array($post_data)) {
        $str = "";
        foreach ($post_data as $item) $str .= "$item<br />";
        echo $str;
      } else {
        echo $post_data;
      }
    }
  }

  public function admin_columns_sort($columns) {
    foreach ($this->data as $key => $value) $columns["$key"] = $key;
    return $columns;
  }

  public function admin_column_style() {
    echo '<style type="text/css">';
    echo '.column-image,.column-bg,.column-background,.column-img { width: 80px; }';
    echo '</style>';
  }
}
