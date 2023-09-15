<?php

/**
 * layout: woo/sidebar
 */

$has_subcategories = false;

// get only main product categories
$categories = get_terms([
  'taxonomy' => 'product_cat',
  'hide_empty' => true,
  'parent' => 0,
]);

$woo_query = new \TPF\Woo_Query;

?>

<div class="uk-panel">

  <h3 class="uk-h5 uk-text-uppercase uk-margin-small uk-text-bold">
    <?= __x('Categories') ?>
  </h3>

  <?php
  tpf_render('layout/woo/categories-nav', [
    'categories' => $categories,
    'all' => get_permalink(wc_get_page_id('shop')),
  ]);
  ?>

</div>

<?php if (is_product_category()) :

  // get current category object
  $category = get_queried_object();

  // get current category title
  $category_title = $category->name;

  // get parent category title
  if ($category->parent != 0) {
    $category_title = get_term($category->parent)->name;
  }

  $subcategories = get_terms([
    'taxonomy' => 'product_cat',
    'hide_empty' => true,
    'parent' => get_queried_object_id(),
  ]);

  $show_subcats = empty($subcategories) && $category->parent == 0 ? false : true;

  // if current category has no subcategories, get parent subcategories
  if (empty($subcategories) && $show_subcats) {
    $subcategories = get_terms([
      'taxonomy' => 'product_cat',
      'hide_empty' => true,
      'parent' => get_queried_object()->parent,
    ]);
  }
?>
  <?php if ($show_subcats) : ?>
    <div class="uk-panel uk-margin">

      <h3 class="uk-h5 uk-text-uppercase uk-margin-small uk-text-bold">
        <?= $category_title ?>
      </h3>

      <?php
      tpf_render('layout/woo/categories-nav', [
        'categories' => $subcategories,
      ]);
      ?>

    </div>
  <?php endif; ?>
<?php endif; ?>

<div class="uk-panel uk-margin">

  <h3 class="uk-h5 uk-text-uppercase uk-margin-small uk-text-bold">
    <?= __x('Filters') ?>
  </h3>

  <?php
  tpf_render('layout/woo/filters');
  ?>

</div>