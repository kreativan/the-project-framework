<h1>
  <i class="dashicons-before <?= the_project('icon') ?>"></i>
  <?= the_project("name") ?>
</h1>

<hr class="p-margin" />

<?php
  do_action('tpf_dashboard_before');
?>

<div id="tpf-dashboard">
  <div class="p-grid p-grid-gap p-grid-2">

    <div class="left">
      <?php 
        tpf_render("views/_project.php");
        if(the_project('user_groups')) {
          tpf_render("views/_user-groups.php");
        }
      ?>
      <?php
        do_action('tpf_dashboard_grid_left');
      ?>
      
    </div>

    <div class="right">
     <?php tpf_render("views/_menu.php") ?>
      <?php
        do_action('tpf_dashboard_grid_right');
      ?>
    </div>

  </div>
</div>

<?php
  do_action('tpf_dashboard_after');
?>