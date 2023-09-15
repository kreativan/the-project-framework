<?php if (have_posts()) : while (have_posts()) : the_post();

    // Meta
    $date = get_the_date('d M Y');
    $categories = get_the_category();
    $category = $categories[0];

?>

    <h1><?php the_title(); ?></h1>

    <ul class="uk-subnav uk-subnav-divider uk-text-muted uk-margin">
      <li>
        <span> <?= $date ?></span>
      </li>
      <li>
        <a class="uk-link-heading" href="<?= get_category_link($category->term_id) ?>" title="<?= $category->name ?>">
          <?= $category->name ?>
        </a>
      </li>
    </ul>

    <?php
    if (has_post_thumbnail()) {
      echo get_the_post_thumbnail(null, 'large');
    }
    ?>

    <?php
    the_content();
    ?>

    <div>
      <?php
      //comments_template(); 
      ?>
    </div>

<?php endwhile;
endif; ?>