<h1>
  <i class="dashicons-before <?= the_project('icon') ?>"></i>
  <?= the_project("name") ?>
</h1>

<hr class="p-margin" />

<?php
do_action('tpf_dashboard_before');
?>


<div id="tpf-dashboard" class="tpf-grid" data-grid="3" data-grid-l="2">

  <?php
  tpf_include("admin/views/_project.php");
  tpf_include("admin/views/_menu.php");
  do_action('tpf_dashboard_grid');
  ?>

</div>

<?php
do_action('tpf_dashboard_after');
?>