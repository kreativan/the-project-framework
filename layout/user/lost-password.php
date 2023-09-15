<p>
  <?= __('Please enter your username or email address. You will receive an email message with instructions on how to reset your password.', 'the-project-framework') ?>
</p>

<form id="lost-password-form" action="/ajax/user/lost-password/" method="POST" class="uk-form-stacked">

  <div class="uk-margin">
    <label class="uk-form-label" for="input-user_login">Email</label>
    <input id="input-user_login" class="uk-input" type="email" name="user_login" />
  </div>

  <div class="uk-margin">
    <button class="uk-button uk-button-primary" type="button" onclick="tpf.formSubmit('lost-password-form')">
      <?= __('Reset Password', 'the-project-framework') ?>
    </button>
    <span class="ajax-indicator uk-hidden uk-margin-left" uk-spinner></span>
  </div>

</form>