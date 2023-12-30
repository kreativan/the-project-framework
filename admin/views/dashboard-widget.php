<?php

/**
 * The Project : Dashboard Widget
 */

if (!defined('ABSPATH')) {
  exit;
}

$menus = wp_get_nav_menus();

?>

<!-- Project -->

<div class="p-margin">

  <h4 class="p-flex p-flex-between">
    <span>
      <i class="dashicons-before dashicons-dashboard"></i>
      Project
    </span>
    <ul class="p-list p-flex p-margin-remove">
      <li style="margin-left: 5px;">
        <a href="<?= get_admin_url() ?>admin.php?page=site-settings" title="Site Settings">
          <i class="dashicons-before dashicons-admin-settings"></i>
        </a>
      </li>
      <li style="margin-left: 5px;">
        <a href="<?= get_admin_url() ?>options-general.php?page=project-settings&tab=developer" title="The Project Settings">
          <i class="dashicons-before dashicons-admin-generic"></i>
        </a>
      </li>
    </ul>
  </h4>

  <ul class="p-list p-list-striped">

    <li class="p-flex p-flex-between">
      <span>Name</span>
      <b><?= the_project("name") ?></b>
    </li>

    <li class="p-flex p-flex-between">
      <span>Dev Mode</span>
      <?= the_project("dev_mode") ? "<b class='p-text-danger'>On</b>" : "<b>Off</b>" ?>
    </li>

    <?php if (class_exists('WooCommerce')) : ?>
      <li class="p-flex p-flex-between">
        <span>WooCommerce</span>
        <?= the_project("woo") ? "<b class='p-text-success'>On</b>" : "<b>Off</b>" ?>
      </li>
    <?php endif; ?>

    <li class="p-flex p-flex-between">
      <span>SMTP</span>
      <?= the_project("smtp_enable") ? "<b class='p-text-success'>On</b>" : "<b>Off</b>" ?>
    </li>

    <?php do_action('tpf_dashboard_info_list'); ?>

  </ul>

</div>

<!-- Menus -->

<div>
  <h4>
    <i class="dashicons-before dashicons-menu"></i>
    Menus
  </h4>

  <?php if (count($menus) > 0) : ?>
    <ul class="p-list p-list-striped">
      <?php foreach ($menus as $menu) : ?>
        <li class="p-flex p-flex-between">
          <span>
            <a class="p-link" href="nav-menus.php?action=edit&menu=<?= $menu->term_id ?>">
              <?= $menu->name ?>
            </a>
          </span>
          <span>
            <?= $menu->count ?>
          </span>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else : ?>
    No menus to display. Clieck <a href="<?= get_admin_url() ?>/nav-menus.php">here</a> to create a menu
  <?php endif; ?>
</div>