<?php 
$i = 0;

if( have_posts() && get_the_title() != 'Search') : while( have_posts() ) : the_post(); ?>

  <?php if($i++ > 0) echo "<hr class='uk-margin-medium' />"; ?>

  <article class="uk-margin">

    <?php if(has_post_thumbnail()) : ?>
    <div class="uk-grid" uk-grid>
      <div class="uk-width-1-3@m">
        <img src="<?= the_post_thumbnail_url('blog-small') ?>" loading="lazy" alt="<?php the_title(); ?>" />
      </div>
      <div class="uk-width-expand@m">
        <h2><?php the_title(); ?></h2>
        <?php the_excerpt(); ?>
        <a href="<?= the_permalink() ?>" class="uk-button uk-button-text" title="<?= the_title() ?>">
          Read More
        </a>
      </div>
    </div>
    <?php else :?>
      <h2><?php the_title(); ?></h2>
      <?php the_excerpt(); ?>
      <a href="<?= the_permalink() ?>" class="uk-button uk-button-text" title="<?= the_title() ?>">
        Read More
      </a>
    <?php endif; ?>

  </article>

<?php endwhile; else : ?> 
  <p>There are no results for the search term.</p>
<?php endif; ?>
