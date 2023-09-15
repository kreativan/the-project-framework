<?php
$navbar = tpf_get_menu_array('Main Menu');
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<ul class="uk-navbar-nav">
  <?php foreach ($navbar as $item) : ?>

    <?php
    $submenu = isset($item['submenu']) && count($item['submenu']) > 0 ? true : false;
    $class = "menu-item";
    if ($submenu) $class .= " uk-parent";
    if ($item['href'] == $actual_link) $class .= " uk-active";
    ?>

    <li class="<?= $class ?>">
      <a href="<?= $item['href'] ?>">
        <?= $item['title'] ?>
        <?php if ($submenu) : ?>
          <i class="uk-icon" uk-icon="chevron-down"></i>
        <?php endif; ?>
      </a>
      <?php if ($submenu) : ?>
        <div class="uk-navbar-dropdown">
          <ul class="uk-nav uk-navbar-dropdown-nav">
            <?php foreach ($item['submenu'] as $subitem) : ?>
              <li>
                <a href="<?= $subitem['href'] ?>">
                  <?= $subitem['title'] ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </li>

  <?php endforeach; ?>
</ul>