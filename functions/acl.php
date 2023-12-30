<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Protected Access
 * 
 * Sometimes we need to protect content and user uploaded files from public access.
 * Functions below are used to define which roles can have access.
 * 
 * @see /ajax/force-open.php for example usage
 * 
 * Use filter to extend the roles array 
 * @example
 * add_filter('TPF_Protected_Access', function($roles) {
 *   $roles[] = 'factory';
 *    return $roles;
 * });
 * 
 */

function TPF_Protected_Access() {
  $roles =  [
    'administrator',
  ];
  // add filter to make it possible to extend the array
  $roles = apply_filters('TPF_Protected_Access', $roles);
  return $roles;
}

function TPF_Has_Protected_Access() {
  $user = wp_get_current_user();
  $allowed = TPF_Protected_Access();
  foreach ($allowed as $role) {
    if (in_array($role, $user->roles)) return true;
  }
  return false;
}
