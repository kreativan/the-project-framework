<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>

    <article>
      <h2><?php the_title(); ?></h2>
      <p><?php the_excerpt(); ?></p>
      <a href="<?= the_permalink() ?>">Read More</a>
    </article>

  <?php endwhile; ?>
<?php endif; ?>