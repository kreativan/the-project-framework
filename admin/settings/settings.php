<?php

/**
 *  Developer Settings
 *  @author Ivan Milincic <kreativan.dev@gmail.com>
 *  @link http://kraetivan.dev
 */

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class The_Project_Settings {

  public function __construct() {

    $options = get_option('project_settings');
    add_action('admin_menu', [$this, 'settings_page']);
    add_action('admin_init', [$this, 'project_settings']);
  }

  // Settings Page
  public function settings_page() {
    add_options_page(
      'The Project Settings', // page_title
      'The Project', // menu_title
      'manage_options', // permission
      'project-settings', // slug
      [$this, 'render_settings_page']
    );
  }

  public function render_settings_page() {
    include("settings-form-custom.php");
  }

  /**
   *  Define Settings
   *  @method register_setting()
   *  @method add_settings_section()
   *  @method add_settings_field()
   */
  public function project_settings() {

    register_setting(
      'project_settings', // options group
      'project_settings', // options_name
    );
  }
}
