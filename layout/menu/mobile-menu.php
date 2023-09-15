<?php

$menu_name = wp_get_nav_menu_name('mobile-menu');
$mobile_menu = tpf_get_menu_array($menu_name);

if (isset($_GET['actual_link'])) {
  $actual_link = $_GET['actual_link'];
} else {
  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

?>

<button class="uk-offcanvas-close uk-position-small" type="button" uk-close="ratio:1.5"></button>

<ul id="mobile-menu-nav" class="uk-nav uk-nav-primary uk-nav-parent-icon uk-margin-auto-vertical uk-margin-remove-left" uk-nav>
  <?php foreach ($mobile_menu as $item) : ?>

    <?php

    $class = "menu-item";
    $submenu = isset($item['submenu']) && count($item['submenu']) > 0 ? $item['submenu'] : false;
    if ($submenu) $class .= " uk-parent";

    $href = isset($item['href']) ? $item['href'] : "#";
    if ($href == $actual_link) $class .= " uk-active";

    $title = isset($item['title']) ? $item['title'] : "";

    $attr_title = isset($item['attr_title']) ? $item['attr_title'] : $title;
    $attr = "title='$attr_title'";
    if (isset($item['target'])) $attr .= " target='{$item['target']}'";

    ?>

    <li class="<?= $class ?>">

      <a href="<?= $href ?>" <?= $attr ?>>
        <?= $title ?>
        <?php if ($submenu) : ?>
          <span uk-nav-parent-icon></span>
        <?php endif; ?>
      </a>

      <?php if ($submenu) : ?>
        <ul class="uk-nav-sub" style="padding-left:0;">
          <?php foreach ($submenu as $subitem) : ?>

            <?php

            $class = "menu-subitem";
            $lvl3 = isset($subitem['submenu']) && count($subitem['submenu']) > 0 ? $subitem['submenu'] : false;
            if ($lvl3) $class .= " uk-parent";

            $href = isset($subitem['href']) ? $subitem['href'] : "#";
            if ($href == $actual_link) $class .= " uk-active";;

            $title = isset($subitem['title']) ? $subitem['title'] : "";

            $attr_title = isset($subitem['attr_title']) ? $subitem['attr_title'] : $title;
            $attr = "title='$attr_title'";
            if (isset($item['target'])) $attr .= " target='{$subitem['target']}'";

            ?>

            <li class="<?= $class ?>">

              <a href="<?= $href ?>" <?= $attr ?>>
                <?= $title ?>
              </a>

              <?php if ($lvl3) : ?>
                <ul class="uk-nav-sub subnav-lvl3">
                  <?php foreach ($lvl3 as $lvl3_item) : ?>
                    <li class="menu-subitem-lvl3">
                      <a href="<?= $lvl3_item['href'] ?>">
                        <?= $lvl3_item['title'] ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>

            </li>

          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

    </li>

  <?php endforeach; ?>
</ul>