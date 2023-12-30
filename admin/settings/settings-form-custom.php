<?php

/**
 *  Custom Settings Form
 *  @author Ivan Milincic <kreativan.dev@gmail.com>
 *  @link http://kraetivan.dev
 */

if (!defined('ABSPATH')) {
  exit;
}


$project_arr = [];
$developer_arr = [];
$users_arr = [];
$features_arr = [];
$woo_arr = [];

include('_project.php');
include('_dev.php');
include('_users.php');
include('_features.php');
include('_woo.php');


$subnav = [
  'project' => 'Project',
  'developer' => 'Developer',
  'users' => 'Users',
  'features' => 'Features',
];

if (class_exists('WooCommerce')) {
  $subnav['woo'] = "WooCommerce";
}

$content = [];

$content['developer'] = [
  'array' => $developer_arr,
  'button' => 1,
  'grid' => 2,
  'grid_l' => 1,
];

$content['users'] = [
  'array' => $users_arr,
  'button' => 1,
  'grid' => 2,
  'grid_l' => 1,
];

$content['features'] = [
  'array' => $features_arr,
  'button' => 1,
  'grid' => count($features_arr) > 3 ? 2 : 1,
  'grid_l' => 1,
];

if (class_exists('WooCommerce')) {
  $content['woo'] = [
    'array' => $woo_arr,
    'button' => 1,
    'grid' => 2,
    'grid_l' => 1,
  ];
}

?>

<h1 class="p-margin">
  <span class="dashicons dashicons-admin-generic" style="font-size: 1em;margin-right:5px;position:relative;top:-3px"></span>
  The Project Framework
  <img class="htmx-indicator" src="/wp-admin/images/spinner.gif" />
</h1>

<hr class="p-margin" />

<ul class="p-subnav p-tabs-nav p-margin">
  <?php foreach ($subnav as $id => $label) : ?>
    <?php
    $active = "";
    if (isset($_GET['tab']) && $_GET['tab'] == $id) {
      $active = 'p-active';
    } elseif ($id == 'project' && !isset($_GET['tab'])) {
      $active = 'p-active';
    }
    ?>
    <li>
      <a class="p-tabs-nav <?= $active ?>" href="<?= admin_url() . "options-general.php?page=project-settings&tab=$id" ?>" hx-get="./options-general.php?page=project-settings&tab=<?= $id ?>" hx-select="#wpbody-content" hx-target="#wpbody-content" hx-swap="outerHTML" hx-indicator=".htmx-indicator">
        <?= $label ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>

<form id="tpf-settings-form" class="p-form p-margin-remove" action="options.php" method="post" hx-boost="true" hx-indicator=".htmx-indicator">

  <?php
  settings_fields('project_settings');
  do_settings_sections('project-settings');
  ?>


  <div id="project" class="p-tabs-content <?= !isset($_GET['tab']) || $_GET['tab'] == 'project' ? "p-active" : "p-hidden" ?>">
    <?php
    tpf_include("admin/settings/loop.php", [
      "array" => $project_arr,
      "button" => 1,
      "id" => "project",
    ]);
    do_action('tpf_project_settings');
    ?>
  </div>

  <?php foreach ($content as $key => $item) : ?>
    <div id="<?= $key ?>" class="tpf-grid p-tabs-content <?= isset($_GET['tab']) && $_GET['tab'] == $key ? "p-active" : "p-hidden" ?>" data-grid="<?= $item['grid'] ?>" data-grid-l="<?= $item['grid_l'] ?>">
      <?php
      tpf_include("admin/settings/loop.php", [
        "array" => $item['array'],
        "button" => 1,
        "margin" => 0,
      ]);
      ?>
    </div>
  <?php endforeach; ?>


  <!--
  <div class="p-margin-top p-text-left">
    <input
      type="submit"
      name="submit"
      class="p-btn"
      value="<?php esc_attr_e('Save Settings'); ?>"
    />
  </div>

  -->

</form>