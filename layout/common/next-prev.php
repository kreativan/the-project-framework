<?php
// prev
$prev_post = get_previous_post(); 
if($prev_post) {
  $prev_id = $prev_post->ID ;
  $prev_permalink = get_permalink($prev_id);
}

// next
$next_post = get_next_post();
if($next_post) {
  $next_id = $next_post ? $next_post->ID  : false;
  $next_permalink = $next_id ? get_permalink($next_id) : false;
}

?>

<?php if($prev_post || $next_post) : ?>
<div class="uk-grid uk-grid-small uk-flex-middle uk-text-small" uk-grid>

  <div class="uk-width-auto@m">
    <?php if($prev_post) :?>
    <a href="<?= $prev_permalink ?>" class="uk-link-reset" title="<?= $prev_post->post_title ?>">
      <span class="uk-text-muted"><?= __x('Article en avant-première') ?></span>
      <h5 class="uk-h6 uk-margin-remove">
        <?= tpf_short_text($prev_post->post_title, 30) ?>
      </h5>
    </a>
    <?php endif;?>
  </div>

  <div class="uk-width-expand uk-text-center uk-visible@m"></div>

  <div class="uk-width-auto@m">
    <?php if($next_post) :?>
    <a href="<?= $next_permalink ?>" class="uk-link-reset" title="<?= $next_post->post_title ?>">
      <span class="uk-text-muted"><?= __x('Prochain article') ?></span>
      <h5 class="uk-h6 uk-margin-remove">
        <?= tpf_short_text($next_post->post_title, 30) ?>
      </h5>
    </a>
    <?php endif;?>
  </div>

</div>
<?php endif;?>