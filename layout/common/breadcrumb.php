<?php

/**
 * layout/common/breadcrumb.php
 */

$home_title = get_the_title(get_option('page_on_front'));

$is_cat = is_category() || is_single() ? true : false;
$cat_name = $is_cat ? get_the_category()[0]->cat_name : "";

?>

<?php if (function_exists('woocommerce_breadcrumb')) : ?>
  <?php woocommerce_breadcrumb() ?>
<?php else : ?>
  <ul class="uk-breadcrumb">

    <li>
      <a href="<?= home_url() ?>"><?= $home_title ?></a>
    </li>

    <?php if ($is_cat && $cat_name != "Uncategorized") : ?>
      <li>
        <a href="<?= get_category_link(get_the_category()[0]->term_id) ?>">
          <?= get_the_category()[0]->cat_name ?>
        </a>
      </li>
      <?php if (is_single()) : ?>
        <li>
          <span><?= the_title() ?></span>
        </li>
      <?php endif; ?>
    <?php elseif (is_single()) : ?>
      <li>
        <span><?= the_title() ?></span>
      </li>
    <?php elseif (is_page()) : ?>
      <li>
        <span><?= the_title() ?></span>
      </li>
    <?php endif; ?>

  </ul>

<?php endif; ?>