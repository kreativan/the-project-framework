<?php

/**
 * Layout: wp/blog-grid
 *
 */

?>

<div class="uk-grid" uk-grid="masonry: true">
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <div class="uk-width-1-2@m">

        <article>

          <h2 class="uk-h3">
            <a class="uk-link-heading" href="<?= the_permalink() ?>" title="<?php the_title(); ?>">
              <?php the_title(); ?>
            </a>
          </h2>

          <p class="uk-text-meta"><?= get_the_date('d M Y'); ?></p>

          <p><?php the_excerpt(); ?></p>

          <a href="<?= the_permalink() ?>" title="<?php the_title(); ?>">
            <?= __('Read More', 'the-project-framework'); ?>
          </a>
        </article>

      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>