<?php
$user = wp_get_current_user();
?>

<div id="htmx-offcanvas" class="user-nav-offcanvas" uk-offcanvas="overlay: true; flip: true;">
  <div class="uk-offcanvas-bar uk-flex uk-flex-column">

    <button class="uk-offcanvas-close uk-position-small" type="button" uk-close="ratio:1.5"></button>

    <h3 class="uk-h4 uk-text-light uk-margin-large-top"><?= sprintf(__x('Hello %s'), $user->display_name); ?></h3>

    <?php
    render('layout/user/user-nav', [
      // 'class' => "uk-nav-primary uk-margin-auto-vertical",
      'class' => 'uk-nav-primary',
      'attr' => 1,
    ]);
    ?>

  </div>
</div>