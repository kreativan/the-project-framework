<?php

/**
 * layout: reviews-offcanvas
 */
?>

<div id="htmx-offcanvas" uk-offcanvas="overlay: true">
  <div class="uk-offcanvas-bar uk-padding-remove uk-width-large@m">

    <button class="uk-offcanvas-close uk-text-primary" type="button" uk-close="ratio: 1.3"></button>

    <div class="uk-padding-small">
      <h2 class="uk-margin-remove"><?= __x('Reviews'); ?></h2>

      <?php if (is_user_logged_in()) : ?>
        <button type="button" class="uk-button uk-button-link" onclick="document.querySelector('#submit-review-form').classList.toggle('uk-hidden')">
          <?= __x('Write a review') ?>
          <i uk-icon="icon: pencil; ratio: 0.9"></i>
        </button>
      <?php else : ?>
        <p class="uk-text-muted uk-text-small uk-margin-remove">
          <?= __x('You have to be logged in to submit a review.') ?>
        </p>
      <?php endif; ?>

      <?php
      tpf_render('layout/woo/reviews-submit-form', [
        'product_id' => $product_id,
      ]);
      ?>
    </div>

    <?php
    tpf_render('layout/woo/reviews-list', [
      'product_id' => isset($_GET['product_id']) ? $_GET['product_id'] : 0,
      'per_page' => !empty($_GET['per_page']) ? $_GET['per_page'] : 10,
      'paged' => !empty($_GET['paged']) ? $_GET['paged'] : 1,
    ]);
    ?>

  </div>
</div>