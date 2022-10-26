<div class="p-card p-padding p-margin">

  <h2 class="p-flex p-flex-between">
    <span>
      <i class="dashicons-before dashicons-dashboard"></i>
      Info
    </span>
    <a href="<?= get_admin_url() ?>options-general.php?page=project-settings">
      <i class="dashicons-before dashicons-admin-generic"></i>
    </a>
  </h2>

  <ul class="p-list p-list-striped">

    <li class="p-flex p-flex-between">
      <span>Dev Mode</span>
      <?= the_project("dev_mode") ? "<b class='p-text-danger'>On</b>" : "<b>Off</b>" ?>
    </li>

    <?php if(class_exists('WooCommerce')) : ?>
    <li class="p-flex p-flex-between">
      <span>WooCommerce</span>
      <?= the_project("woo") ? "<b class='p-text-success'>On</b>" : "<b>Off</b>" ?>
    </li>
    <?php endif;?>

    <li class="p-flex p-flex-between">
      <span>SMTP</span>
      <?= the_project("smtp_enable") ? "<b class='p-text-success'>On</b>" : "<b>Off</b>" ?>
    </li>

    <?php do_action('tpf_dashboard_info_list'); ?>
    
  </ul>

</div>
