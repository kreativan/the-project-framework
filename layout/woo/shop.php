<?php

/**
 * layout: woo/shop
 * 
 * Base
 * woocommerce_page_title();
 * woocommerce_taxonomy_archive_description();
 * woocommerce_product_archive_description();
 * 
 * General
 * woocommerce_result_count();
 * 
 */

?>

<div class="woo-shop-heading uk-margin-medium">
  <h1 class="uk-margin">
    <?php woocommerce_page_title(); ?>
  </h1>
  <?php
  woocommerce_taxonomy_archive_description();
  woocommerce_product_archive_description();
  ?>
</div>

<div class="woocommerce woo-shop uk-grid" uk-grid>

  <div class="uk-width-auto@m uk-visible@l">
    <div id="woo-sidebar" style="min-width: 180px;">
      <?php render('layout/woo/sidebar'); ?>
    </div>
  </div>

  <div id="woo-products-grid" class="uk-width-expand@m">
    <?php
    woocommerce_content();
    ?>
  </div>

</div>