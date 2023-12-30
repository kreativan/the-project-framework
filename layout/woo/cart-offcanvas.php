<?php

/**
 * Layout: woo/cart-offcanvas.php
 */
$cart = WC()->cart->get_cart();
$cart_page_title = get_the_title(wc_get_page_id('cart'));
?>

<div id="htmx-offcanvas" class="offcanvas-cart" uk-offcanvas="overlay: true; flip: true;">
  <div class="uk-offcanvas-bar uk-width-auto@s uk-width-5-6 uk-width-large@m">

    <button class="uk-offcanvas-close uk-text-primary uk-position-small" type="button" uk-close="ratio: 1.3"></button>

    <h2 class="uk-text-bold uk-margin uk-position-relative">
      <?= $cart_page_title ?>
    </h2>

    <div id="woo-cart-items">
      <?php
      render('layout/woo/cart-table');
      ?>
    </div>

    <div class="uk-margin-medium-top">
      <div class="uk-margin-small">
        <a href="/cart/" class="uk-button uk-button-default uk-width-1-1">
          <?= __('View Cart', 'the-project-framework') ?>
        </a>
      </div>
      <div class="uk-margin-small">
        <a href="/checkout/" class="uk-button uk-button-primary uk-width-1-1">
          <?= __('Checkout', 'the-project-framework') ?>
        </a>
      </div>
    </div>

  </div>
</div>