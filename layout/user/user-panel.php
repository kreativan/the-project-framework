<?php

/**
 * Main user panel page
 * default page is dashboard
 * other (child) pages are rendered by the slug
 */

$TPF = new TPF();

global $post;
$user = wp_get_current_user();

$view = "layout/user/{$post->post_name}";
if (tpf_user_page('ID') == $post->ID) $view = "layout/user/dashboard";

$view_tmpl = get_template_directory() . "/{$view}.php";
$view_plg = $TPF->path() . "{$view}.php";

?>

<?php if (is_user_logged_in()) : ?>

  <h1 class="uk-margin-remove">
    <?php if ($post->ID == tpf_user_page('ID')) : ?>
      <?= sprintf(__x('Hello %s'), $user->display_name); ?>
    <?php else : ?>
      <?= get_the_title(); ?>
    <?php endif; ?>
  </h1>

  <p class="uk-text-muted uk-margin-remove-top">
    <?= sprintf(__x('You are logged in as %s'), $user->user_login); ?>
  </p>

  <div class="uk-grid uk-grid-divider" uk-grid>

    <div class="uk-width-expand@m">
      <div>
        <?php
        if (file_exists($view_plg) || file_exists($view_tmpl)) {
          tpf_render($view, [
            "user" => $user,
          ]);
        } else {
          the_content();
        }
        ?>
      </div>
    </div>

    <div class="uk-width-medium@m uk-visible@m">
      <div>
        <?php tpf_render('layout/user/user-nav') ?>
      </div>
    </div>

  </div>

<?php elseif (isset($_GET['action']) && $_GET['action'] == 'lostpassword') : ?>

  <div>
    <h1><?= __x('Lost Password?') ?></h1>
    <?php
    tpf_include('layout/user/lost-password');
    ?>
  </div>

<?php elseif (isset($_GET['action']) && $_GET['action'] == 'rp') : ?>

  <div>
    <h1><?= __x('Reset Password') ?></h1>
    <?php
    tpf_include('layout/user/reset-password');
    ?>
  </div>

<?php else : ?>

  <div class="uk-width-large@s uk-margin-auto">
    <h1><?= __x('Login') ?></h1>
    <?php
    tpf_include('layout/user/login-form');
    ?>
  </div>

<?php endif; ?>