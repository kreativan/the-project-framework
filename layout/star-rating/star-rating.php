<?php

/**
 * layout: rating-stars
 * @var int $rating 0-5
 * @var float|string ratio
 * @var string $class
 */

$total = 5;
$rating = !empty($rating) ? $rating : 0;
$rating = round($rating, 0);
$empty = $total - $rating;

$class = !empty($class) ? " $class" : '';
$ratio = !empty($ratio) ? $ratio : 1;
?>

<div class="rating-stars<?= $class ?>">
  <?php for ($i = 0; $i < $rating; $i++) : ?>
    <span class="uk-text-warning" uk-icon="icon: star; ratio: <?= $ratio ?>"></span>
  <?php endfor; ?>
  <?php for ($i = 0; $i < $empty; $i++) : ?>
    <span class="uk-text-muted" uk-icon="icon: star; ratio: <?= $ratio ?>"></span>
  <?php endfor; ?>
</div>