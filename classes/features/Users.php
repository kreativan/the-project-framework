<?php

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class Users {

  public function __construct() {

    // Allow subscriber to see private pages
    $subscriber = get_role('subscriber');
    $subscriber->add_cap('read_private_posts');
    $subscriber->add_cap('read_private_pages');


    // Password reset email message
    add_filter('retrieve_password_message', array($this, 'replace_retrieve_password_message'), 10, 4);

    // If password reset key is invalid redirect to user page
    add_action('init', [$this, 'check_password_reset_key']);

    // prevent delete user pages
    if (the_project('lock_user_pages')) {
      add_action('pre_trash_post', [$this, 'no_delete'], 10, 1);
      add_filter('page_row_actions', [$this, 'remove_quick_actions'], 10, 2);
    }

    /**
     * Shortcodes
     */
    add_shortcode('tpf_login_form', function () {
      ob_start();
      render("layout/user/login-form");
      $content = ob_get_clean();
      return $content;
    });

    add_shortcode('tpf_user', function ($attr) {
      $user = wp_get_current_user();
      $field_name = $attr['val'];
      return $user->{$field_name};
    });

    // add custom meta box
    if (is_admin()) {

      if (isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['post'])) {
        $tmpl = get_post_meta($_GET['post'], '_wp_page_template', true);
        if ($tmpl == 'user-panel.php') {
          add_action('add_meta_boxes', [$this, 'metaboxes']);
        }
      }

      /**
       * Add user dashboard page state
       */
      add_filter('display_post_states', function ($states, $post) {
        $user_page_id = tpf_user_page('ID');
        if (!$user_page_id || empty($user_page_id)) return $states;
        if ($post->ID == $user_page_id) $states[] = 'User Dashboard';
        if (wp_get_post_parent_id() == $user_page_id) $states[] = 'User Page';
        return $states;
      }, 10, 2);
    }
  }

  //--------------------------------------------------------
  //  Password Reset
  //--------------------------------------------------------

  /**
   * Check if password reset key is valid
   * redirect to user page (login) if invalid
   */
  public function check_password_reset_key() {
    if ($GLOBALS['pagenow'] != 'wp-login.php') {
      if (isset($_REQUEST['key']) && isset($_REQUEST['login'])) {
        $user_page_url = tpf_user_page('url');
        $user = check_password_reset_key($_REQUEST['key'], $_REQUEST['login']);
        if (!$user || is_wp_error($user)) {
          //dump($user);
          wp_redirect($user_page_url);
          exit();
        }
      }
    }
  }

  /**
   * Returns the message body for the password reset mail.
   * Called through the retrieve_password_message filter.
   *
   * @param string  $message    Default mail message.
   * @param string  $key        The activation key.
   * @param string  $user_login The username for the user.
   * @param WP_User $user_data  WP_User object.
   *
   * @return string   The mail message to send.
   */
  public function replace_retrieve_password_message($message, $key, $user_login, $user_data) {
    $user_page = tpf_user_page('post_name');
    $msg = str_replace('wp-login.php', "$user_page/", $message);
    return $msg;
  }

  //--------------------------------------------------------
  //  Admin
  //--------------------------------------------------------

  public function no_delete($post) {
    $admin_url = admin_url('edit.php?post_type=page');
    global $post;
    $upID = tpf_user_page('ID');
    $parentID = wp_get_post_parent_id($post);
    if ($post->ID == $upID || $parentID == $upID) {
      wp_redirect($admin_url);
      exit();
    }
  }

  public function remove_quick_actions($actions, $post) {
    unset($actions['inline hide-if-no-js']);
    $upID = tpf_user_page('ID');
    $parentID = wp_get_post_parent_id($post);
    if ($post->ID == $upID || $parentID == $upID) {
      unset($actions['trash']);
    }
    return $actions;
  }

  public function metaboxes() {
    add_meta_box(
      'tpf-users-meta-box', // id, used as the html id att
      __('User Panel'), // meta box title, like "Page Attributes"
      [$this, 'meta_box_content'], // callback function, spits out the content
      tpf_user_page('id'), // post type or page. We'll add this to pages only
      'side', // context (where on the screen
      'low' // priority, where should this go in the context?
    );
  }

  public function meta_box_content($post) {
    $layout = $post->ID == tpf_user_page('ID') ? 'dashboard' : $post->post_name;
    echo "<p>For custom user page you create a layout file, or use different page template...</p>";
    echo "<code>/layout/user/{$layout}.php</code></h4>";
    echo "<p>Get any user field:</p>";
    echo "<code>[tpf_user val=display_name]</code>";
    do_action('tpf_user_panel_metabox');
  }
}
