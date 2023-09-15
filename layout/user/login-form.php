<form id="login-form" action="/ajax/user/login/" method="POST" class="uk-form-stacked">

  <div class="uk-margin-">
    <label class="uk-form-label" for="input-user_login"><?= __x('User name or Email') ?></label>
    <input id="input-user_login" class="uk-input" type="text" name="user_login" />
  </div>

  <div class="uk-margin">
    <label class="uk-form-label" for="input-user_password"><?= __x('Password') ?></label>
    <input id="input-user_password" class="uk-input" type="password" name="user_password" />
  </div>

  <div class="uk-margin">
    <label class="uk-form-label">
      <input class="uk-checkbox" type="checkbox" name="remember" value="1" />
      <span class="uk-margin-small-left"><?= __x('Remember Me') ?></span>
    </label>
  </div>

  <div class="uk-margin-top">
    <button type="button" class="uk-button uk-button-primary" onclick="tpf.formSubmit('login-form')">
      <?= __x('Login') ?>
    </button>
  </div>

  <div class="uk-margin-top">
    <a href="<?= tpf_user_page('url') ?>?action=lostpassword" class="uk-text-muted">
      <?= __x('Forgot your password?') ?>
    </a>
  </div>

</form>