<?php
$q1 = rand(1,9);
$q2 = rand(1,9);
?>

<div class="uk-grid uk-child-width-expand uk-grid-small uk-flex-middle" uk-grid>
  <div class="uk-width-auto uk-text-right">
    <input type="hidden" name="q1" value="<?= $q1 ?>" />
    <input type="hidden" name="q2" value="<?= $q2 ?>" />
    <span class="uk-h4 uk-margin-remove uk-text-muted"><?= $q1 ?> + <?= $q2 ?> ?</span>
  </div>
  <div class="uk-width-expand@m">
    <input class="uk-input uk-form-width-small" type="text" name="answ" required />
  </div>
</div>
