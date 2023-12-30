<?php

/**
 * single.php
 *  Default Single Post Template
 */

// Meta
$date = get_the_date('d M Y');
$categories = get_the_category();
$category = $categories[0];

$thumb = get_the_post_thumbnail(null, 'large');

?>

<article class="uk-article">

  <h1 class="uk-margin tm-text-balance uk-width-3-4@l">
    <?php the_title(); ?>
  </h1>

  <?php render("layout/common/breadcrumb", ['align' => "left"]) ?>

  <div class="uk-grid uk-grid-divider uk-margin-medium" uk-grid>

    <div class="uk-width-expand@m">
      <div class="uk-margin uk-margin-medium">
        <?= get_the_post_thumbnail(null, 'large'); ?>
        <?php
        the_content();
        ?>
      </div>

    </div>

    <div class="uk-width-1-4@m">
      <ul class="uk-list uk-list-divider">
        <li>
          <h3 class="uk-h5 uk-margin-small uk-flex uk-flex-middle uk-text-bold">
            <?php
            echo tpf_svg('calendar', [
              'size' => "28px",
              'color' => variable('color-primary'),
            ]);
            ?>
            <?= __('Date', 'the-project') ?>
          </h3>
          <div><?= get_the_date('d F Y'); ?></div>
        </li>
        <li>
          <h3 class="uk-h5 uk-margin-small uk-text-bold">
            <?php
            echo tpf_svg('folder', [
              'size' => "28px",
              'color' => variable('color-primary'),
            ]);
            ?>
            <?= __('Category', 'the-project') ?>
          </h3>
          <div><?= $category->name ?></div>
        </li>
      </ul>

    </div>

  </div>

</article>