<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Get default user page
 */
function TPF_User_Page($param = '') {
  $id = the_project('user_page');
  if (empty($id)) return '';
  $post = get_post($id);
  if (empty($id)) return;
  if ($param == 'url') {
    //return get_post_permalink($id);
    return get_home_url() . "/{$post->post_name}/";
  } elseif ($param != "") {
    return $post->{$param};
  } else {
    return get_post($id);
  }
}
