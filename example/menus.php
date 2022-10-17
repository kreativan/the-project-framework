<?php
/**
 * Create admin submenu from any plugin
 */
new The_Project_Sub_Menu([
  "title" => "Submenu",
  "slug" => "project-submenu",
  "view" => "custom-submenu", // /my-plugin-folder/views/custom-submenu.php
  "parent" => "project", // ?page=project
  "plugin" => "my-plugin-folder", // plugin folder
]);

// Submenu as a scortcut to post_type
new The_Project_Sub_Menu([
  "title" => __('Forms'),
  "slug" => "edit.php?post_type=project-forms"
]);
