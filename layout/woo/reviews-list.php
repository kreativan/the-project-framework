<?php

/**
 * layout: woo/reviews-list
 * @var object $reviews
 *
 */


// product_id
$product_id = !empty($product_id) ? $product_id : '';
$product_id = !empty($_GET['product_id']) ? $_GET['product_id'] : $product_id;

// comments per page
$per_page = !empty($per_page) ? $per_page : 20;
$per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : $per_page;
$next_page = $paged + 1;

// current page
$paged = !empty($paged) ? (int) $paged : (int) 1;
$paged = !empty($_GET['page']) ? (int) $_GET['page'] : (int) $paged;

$args = array(
  'post_id' => $product_id,
  'status' => 'approve',
  'type' => 'review',
  'number' => $per_page, // commnets per page
  'paged' => $paged, // current page
);

$reviews = get_comments($args);

?>

<div id="review-list">
  <?php if (count($reviews) > 0) : ?>
    <hr class="uk-margin-remove" />
    <ul id="reviews" class="uk-list uk-list-divider uk-margin-remove <?= $paged > 1 ? 'uk-animation-slide-bottom-small' : 'uk-animation-fade uk-animation-fast' ?>">
      <?php foreach ($reviews as $review) :
        $review_id = $review->comment_ID;
        $review_author = $review->comment_author;
        $review_content = $review->comment_content;
        $review_date = $review->comment_date;
        $rating = get_comment_meta($review_id, 'rating', true);
      ?>
        <li class="uk-padding-small">
          <ul class="uk-subnav uk-subnav-divider">
            <li class="uk-text-meta"><?= $review_author ?></li>
            <li class="uk-text-meta"><?= date('d M Y', strtotime($review_date)) ?></li>
            <li>
              <?php
              tpf_render('layout/common/rating-stars', [
                'rating' => $rating,
                'ratio' => '0.8',
                // 'class' => "uk-margin-small",
              ]);
              ?>
            </li>
          </ul>
          <p class="uk-margin-small-top uk-text-small"><?= $review_content ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else : ?>
    <hr class="uk-margin-remove" />
    <div class="uk-padding-small">
      <p id="no-reviews" class="uk-text-muted">
        <?= $paged > 1 ? __x('No more reviews.') :  __x('No reviews to display.') ?>
      </p>
    </div>
  <?php endif; ?>
</div>

<hr class="uk-margin-remove" />

<span id="reviews-htmx-indicator" class="uk-margin-small-left uk-text-primary htmx-indicator" uk-spinner="ratio:0.6"></span>

<?php if ($paged == 1 && count($reviews) < $per_page) : ?>

<?php else : ?>
  <div class="uk-padding-small" style="padding-top: 0;padding-bottom: 50px;">
    <button id="load-more-button" type="uk-button" hx-get="?htmx=/layout/woo/reviews-list/&product_id=<?= $product_id ?>&per_page=<?= $per_page ?>&paged=<?= $next_page ?>" hx-target="#review-list" hx-swap="beforeend" hx-select="#review-list" hx-select-oob="#load-more-button" hx-indicator="#reviews-htmx-indicator" class="uk-button uk-button-link uk-button-small uk-text-primary <?= count($reviews) < 1 ? 'uk-hidden' : '' ?>">
      <?= __x('Load more') ?>
    </button>
  </div>
<?php endif; ?>