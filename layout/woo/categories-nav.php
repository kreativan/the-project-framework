<?php

/**
 * layout: woo/categories-nav
 * @var object $categories
 */

$all_url = !empty($all) ? $all : false;
$back_url = !empty($back) ? $back : false;
?>


<ul class="uk-nav uk-nav-default" <?= htmx_nav() ?>>

  <?php if ($back_url) : ?>
    <li class=" <?= is_shop() ? 'uk-active' : '' ?>">
      <a href="<?= $back_url ?>">
        <i uk-icon="arrow-left"></i>
        <?= __x('Back') ?>
      </a>
    </li>
  <?php endif; ?>

  <?php if ($all_url) : ?>
    <li class="<?= is_shop() ? 'uk-active' : '' ?>">
      <a href="<?= $all_url ?>">
        <?= __x('All') ?>
      </a>
    </li>
  <?php endif; ?>

  <?php foreach ($categories as $category) :
    // if current page is this category, add uk-active class
    $class = is_tax('product_cat', $category->slug) ? 'uk-active' : '';
  ?>
    <li class="<?= $class ?>">
      <a href="<?= get_term_link($category) ?>">
        <?= $category->name ?>
      </a>
    </li>
  <?php endforeach; ?>

</ul>