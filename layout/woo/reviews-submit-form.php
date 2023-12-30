<?php

/**
 * layout: woo/review-submit-form
 * @var $product_id
 */

?>

<form id="submit-review-form" action="/ajax/woo/review-submit/" method="POST" class="uk-hidden uk-margin-small">

  <?php
  render('layout/input/star-rating', []);
  ?>

  <input type="hidden" name="product_id" value="<?= $product_id ?>" />

  <textarea class=" uk-textarea" rows="5" name="review" placeholder="<?= __('Your review here', 'the-project-framework') ?>"></textarea>

  <div class="uk-margin-small">

    <button type="button" class="uk-button uk-button-primary uk-button-small" onclick="project.formSubmit('submit-review-form')">
      <?= __('Submit', 'the-project-framework') ?>
    </button>

    <span uk-spinner class="ajax-indicator uk-hidden"></span>

  </div>

</form>