<?php

/**
 * layout: woo/sidebar
 */

// get current page
$current_object_id = get_queried_object_id();
$current_category = get_term($current_object_id, 'product_cat');

// dump($current_category->parent);

// Categories
$categories = get_terms([
  'taxonomy' => 'product_cat',
  'hide_empty' => false,
  'parent' => $current_category->parent ? $current_category->parent : $current_object_id,
]);

?>

<?php if (!is_shop()) : ?>
  <div class="uk-panel uk-margin">

    <h3 class="uk-h5 uk-text-uppercase uk-margin-small uk-text-bold">
      <?= __('Categories', 'the-project-framework') ?>
    </h3>

    <ul class="uk-nav uk-nav-default" uk-nav <?= htmx_nav() ?>>
      <?php foreach ($categories as $category) :
        $class = "";
        $current = get_term($current_object_id, 'product_cat');
        $current_id = !is_shop() && $current->parent ? $current->parent : $current_object_id;
        $is_active = ($current_object_id == $category->term_id) ? true : false;
        $class = $is_active ? 'uk-active' : '';
      ?>
        <li class="<?= $class ?>">
          <a href="<?= get_term_link($category) ?>">
            <?= $category->name ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

  </div>
<?php endif; ?>

<div class="uk-panel uk-margin">

  <?php
  render('layout/woo/filters');
  ?>

</div>