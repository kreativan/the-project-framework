<?php
$menus = wp_get_nav_menus();
?>

<div class="p-card p-padding p-margin">

  <h2>
    <i class="dashicons-before dashicons-menu"></i>
    Menus
  </h2>

  <ul class="p-list p-list-striped">
    <?php foreach($menus as $menu) : ?>
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

</div>
