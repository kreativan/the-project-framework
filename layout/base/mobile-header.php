<?php
$logo = site_settings("logo");

// actual link - used to detect active menu items
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<!-- mobile header -->
<div id="mobile-menu" uk-offcanvas="overlay: true">
  <div class="uk-offcanvas-bar uk-flex uk-flex-column">
    <div class="uk-position-center uk-width-1-1 uk-text-center uk-flex-middle">
      <span uk-spinner></span>
    </div>
  </div>
</div>

<div id="mobile-header" class="uk-hidden@m uk-flex uk-flex-center uk-flex-middle" uk-sticky="show-on-up: true; animation: uk-animation-slide-top">

  <button type="button" class="mobile-menu-button uk-icon uk-position-center-left" <?= htmx_offcanvas('layout/base/mobile-offcanvas/') ?>>
    <img src="<?= tpf_url() ?>lib/svg/menu.svg" uk-svg class="uk-text-emphasis" />
  </button>

  <a href="/" class="uk-h4 uk-text-bold uk-margin-remove uk-link-reset">
    <?php if ($logo) : ?>

    <?php else : ?>
      <span class="uk-text-emphasis">
        <?= site_settings("site_name") ?>
      </span>
    <?php endif; ?>
  </a>

</div>