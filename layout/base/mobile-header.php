<?php
$logo = site_settings("logo");

// actual link - used to detect active menu items
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<!-- mobile menu -->
<div id="mobile-menu" class="uk-offcanvas" uk-offcanvas="overlay: true">
  <div class="uk-offcanvas-bar uk-flex uk-flex-column uk-flex-center">
    <button class="uk-offcanvas-close uk-position-small uk-text-primary" type="button" uk-close="ratio:1.4"></button>
    <div id="mobile-menu-nav">
      <span uk-spinner></span>
      <!-- mobile menu will be loaded here -->
    </div>
  </div>
</div>

<!-- Mobile Header -->
<div id="mobile-header" class="uk-hidden@m uk-flex uk-flex-between uk-flex-middle uk-flex-middle uk-width-1-1" uk-sticky="show-on-up: true; animation: uk-animation-slide-top">

  <a href="#mobile-menu" uk-toggle type="button" class="mobile-menu-button uk-icon uk-position-center-left" hx-get="?htmx=/layout/menu/mobile-menu-wp/&actual_link=<?= $actual_link ?>" hx-target="#mobile-menu-nav" hx-swap="outerHTML">
    <?php
    echo tpf_svg('lib/svg/menu.svg', [
      "folder" => tpf_dir(),
      "size" => "32px",
    ]);
    ?>
  </a>

  <a href="/" class="uk-h4 uk-text-bold uk-margin-remove uk-link-reset uk-position-center">
    <?php if ($logo) : ?>
      <img src="<?= $logo['sizes']['thumbnail'] ?>" alt="<?= $site_name; ?>" />
    <?php else : ?>
      <span class="uk-text-emphasis">
        <?= site_settings("site_name") ?>
      </span>
    <?php endif; ?>
  </a>

</div>