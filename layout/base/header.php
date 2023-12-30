<?php

/**
 * Layout: base/header
 */

$logo = !empty($logo) ? $logo : site_settings("logo");
$site_name = !empty($site_name) ? $site_name : site_settings("site_name");

?>

<div id="navbar" class="uk-visible@l" uk-sticky="show-on-up: true; animation: uk-animation-slide-top">
  <div class="uk-container uk-container-expand">

    <nav class="uk-navbar-container uk-navbar" uk-navbar="boundary: body">

      <div id="logo" class="uk-navbar-left">
        <?php if (!empty($logo)) : ?>
          <a class="logo" href="/">
            <img src="<?= $logo['sizes']['thumbnail'] ?>" alt="<?= $site_name; ?>" />
          </a>
        <?php else : ?>
          <div class="uk-h3 uk-margin-remove">
            <a href="/" class="uk-link-reset">
              <b><?= $site_name; ?></b>
            </a>
          </div>
        <?php endif; ?>
      </div>

      <div id="navigation" class="uk-navbar-center">
        <?php
        render('layout/menu/navbar-wp');
        ?>
      </div>

      <div id="actions" class="uk-navbar-right">
        <a href="#" class="uk-button uk-button-primary uk-button-small" <?= htmx_modal('layout/htmx/modal/') ?>>
          Button
        </a>
      </div>

    </nav>

  </div>
</div>