<?php

namespace TPF;

class Content_Blocks {

  public function __construct($init = false) {

    if ($init) {

      new Post_Type([
        'name' => "tpf_content_blocks",
        "title" => 'Content Blocks',
        "singular_name" => "Content Block",
        "icon" => "dashicons-feedback",
        "menu_position" => 5,
        "submenu_title" => "Content Blocks",
        "supports" => ['title'],
        "admin_columns" => [
          'id' => 'ID',
          'image' => 'Image',
        ],
      ]);

      if (the_project('content_blocks_lock')) {
        add_action('pre_trash_post', [$this, 'no_delete'], 10, 1);
        add_filter('bulk_actions-edit-tpf_content_blocks', [$this, 'remove_bulk_actions']);
        add_filter('page_row_actions', [$this, 'remove_quick_actions'], 10, 2);
      }

      // add custom meta box
      add_action('add_meta_boxes', [$this, 'metaboxes']);

      // Shortcode
      add_shortcode('tpf_content_block', function ($attr) {
        ob_start();
        $id = $attr['id'];
        $content_block = get_post($id);
        tpf_render("layout/blocks/{$content_block->post_name}.php");
        $content = ob_get_clean();
        return $content;
      });
    }
  }

  public function no_delete($post) {
    $admin_url = admin_url('edit.php?post_type=tpf_content_blocks');
    global $post;
    if ($post->post_type == 'tpf_content_blocks') {
      wp_redirect($admin_url);
      wp_die(
        "<h3>$post->post_title is locked.</h3>
        <p>This content block is locked and can not be deleted. Go to Settings -> The Project Content to unlock it.</p>",
        "Error: Can not be deleted",
        [
          'back_link' => true,
          'exit' => true,
        ]
      );
      exit();
    }
  }

  public function remove_bulk_actions($actions) {
    unset($actions['trash']);
    return $actions;
  }

  public function remove_quick_actions($actions, $post) {
    unset($actions['inline hide-if-no-js']);
    if ($post->post_type == 'tpf_content_blocks') {
      unset($actions['trash']);
    }
    return $actions;
  }

  public function metaboxes() {
    add_meta_box(
      'content-blocks-meta-box', // id, used as the html id att
      __('Content Block'), // meta box title, like "Page Attributes"
      [$this, 'meta_box_content'], // callback function, spits out the content
      'tpf_content_blocks', // post type or page. We'll add this to pages only
      'side', // context (where on the screen
      'low' // priority, where should this go in the context?
    );
  }

  public function meta_box_content($post) {
    $admin_url = admin_url();
    $groups = acf_get_field_groups(['post_id' => $post->ID]);
    echo "<p>ID <code>{$post->ID}</code></p>";
    echo "<p>Layout file <br /> <code>{$post->post_name}</code></p>";
    if ($groups && count($groups) > 0) {
      foreach ($groups  as $g) {
        echo "<p>Field Group <br /> <a href='{$admin_url}post.php?post={$g['ID']}&action=edit'>{$g['title']}</a></p>";
      }
    } else {
      echo "<p>Field Group <br /> <a href='{$admin_url}edit.php?post_type=acf-field-group'>Create Field Group</a></p>";
    }
    echo "<p>Shortcode <br /> <code>[tpf_content_block id={$post->ID}]</code></p>";
  }
}
