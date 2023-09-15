<?php

/**
 * layout/common/breadcrumb.php
 */

$home_title = get_the_title(get_option('page_on_front'));
?>

<?php if (function_exists('woocommerce_breadcrumb')) : ?>
  <?php woocommerce_breadcrumb() ?>
<?php else : ?>
  <ul class="uk-breadcrumb">

    <li>
      <a href="<?= home_url() ?>"><?= $home_title ?></a>
    </li>

    <?php if (is_category() || is_single()) : ?>
      <li>
        <a href="<?= get_category_link(get_the_category()[0]->term_id) ?>">
          <?= get_the_category()[0]->cat_name ?> /
        </a>
        <?php if (is_single()) : ?>
          <span><?= the_title() ?></span>
        <?php endif; ?>
      </li>
    <?php elseif (is_page()) : ?>
      <span><?= the_title() ?></span>
    <?php endif; ?>

  </ul>

<?php endif; ?>