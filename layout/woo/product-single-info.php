<?php

/**
 *  layout: woo/product-single-info
 *  @var object $product
 */

$product_id = $product->get_id();

// Rating
$enable_ratings = get_option('woocommerce_enable_reviews');
$rating = $product->get_average_rating();
$rating = round($rating, 0);
$reviews_count = $product->get_rating_count();

// reviews
$reviews_text = $reviews_count > 1 ? __x("%s custumer reviews") : __x("%s custumer review");

// SKU
$sku = ($sku = $product->get_sku()) ? $sku : __x('N/A');

// stock
$global_stock_management = get_option('woocommerce_manage_stock');
$product_stock_management = $product->get_manage_stock();
$stock_qty = $product->get_stock_quantity();
$stock_label_class = $product->is_in_stock() ? 'success' : 'danger';

?>

<!-- Rating + Review -->
<?php if (comments_open($product_id)) : ?>
  <div class="uk-flex uk-flex-middle">

    <?php
    if ($enable_ratings == 'yes') {
      render('layout/common/rating-stars', [
        'rating' => $rating,
        'class' => 'uk-display-inline-block',
        'ratio' => '1',
      ]);
    }
    ?>

    <a href="#" class="uk-margin-small-left" <?= htmx_offcanvas('layout/woo/reviews-offcanvas', ['product_id' => $product_id]) ?>>
      <?php echo sprintf($reviews_text, $reviews_count); ?>
    </a>

  </div>
<?php endif; ?>

<!-- Short Description -->
<p>
  <?= $product->get_short_description() ?>
</p>

<ul class="uk-list uk-list-striped">

  <!-- SKU -->
  <?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>
    <li>
      <?= __x('SKU:') ?>
      <span class="uk-text-emphasis"><?= $sku ?></span>
    </li>
  <?php endif; ?>

  <!-- Stock -->
  <?php if ($global_stock_management == 'yes') :  ?>
    <li>
      <?= __x('Availability: ') ?>
      <span class="uk-label uk-label-<?= $stock_label_class ?>">
        <?php if (get_option('woocommerce_stock_format') == 'no_amount') : ?>
          <?= $product->get_stock_status() ?>
        <?php elseif (get_option('woocommerce_stock_format') == 'low_amount') : ?>
          <?= $stock_qty <= get_option('woocommerce_notify_low_stock_amount') ? $stock_qty : ''; ?>
          <?= $product->get_stock_status() ?>
        <?php else : ?>
          <?= $stock_qty > 0 ? $stock_qty : ''; ?>
          <?= $product->get_stock_status() ?>
        <?php endif; ?>
      </span>
    </li>
  <?php endif; ?>

  <?php
  // Categories
  echo wc_get_product_category_list($product_id, ', ', '<li class="posted_in">' . _n('Category:', 'Categories:', count($product->get_category_ids()), 'woocommerce') . ' ', '</li>');

  // Tags
  echo wc_get_product_tag_list($product_id, ', ', '<li class="tagged_as">' . _n('Tag:', 'Tags:', count($product->get_tag_ids()), 'woocommerce') . ' ', '</li>');
  ?>

</ul>