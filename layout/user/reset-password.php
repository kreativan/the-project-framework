<?php
// $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
// dump($user);
?>

<form id="reset-password-form" action="/ajax/user/reset-password/" method="POST">

  <input type="hidden" name="rp_login" value="<?= esc_attr($_REQUEST['login']) ?>" autocomplete="off" />
  <input type="hidden" name="rp_key" value="<?php echo esc_attr($_REQUEST['key']); ?>" />

  <div class="uk-margin">
    <label class="uk-form-label" for="input-pass1">
      <?= __('New password', 'the-project-framework') ?>
    </label>
    <input id="input-pass1" class="uk-input" type="password" name="pass1" autocomplete="off" />
  </div>

  <div class="uk-margin">
    <label class="uk-form-label" for="input-pass2">
      <?= __('Repeat new password', 'the-project-framework') ?>
    </label>
    <input id="input-pass2" class="uk-input" type="password" name="pass2" autocomplete="off" />
  </div>

  <p class="uk-margin">
    <em><?php echo wp_get_password_hint(); ?></em>
  </p>

  <div class="uk-margin">
    <button class="uk-button uk-button-primary" type="button" onclick="tpf.formSubmit('reset-password-form')">
      <?= __('Reset Password', 'the-project-framework') ?>
    </button>
    <span class="ajax-indicator uk-hidden uk-margin-left" uk-spinner></span>
  </div>

</form>