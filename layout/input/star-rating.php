<?php

/**
 * layout: input/rating-stars
 */

$class = !empty($class) ? $class : '';
?>

<div class="star-rating">
  <input type="hidden" name="rating" value="0" />
  <label>
    <input type="radio" name="star" value="1" onclick="setStarRating()" />
    <?php for ($i = 1; $i <= 1; $i++) : ?>
      <span class="icon">★</span>
    <?php endfor; ?>
  </label>
  <label>
    <input type="radio" name="star" value="2" onclick="setStarRating()" />
    <?php for ($i = 1; $i <= 2; $i++) : ?>
      <span class="icon">★</span>
    <?php endfor; ?>
  </label>
  <label>
    <input type="radio" name="star" value="3" onclick="setStarRating()" />
    <?php for ($i = 1; $i <= 3; $i++) : ?>
      <span class="icon">★</span>
    <?php endfor; ?>
  </label>
  <label>
    <input type="radio" name="star" value="4" onclick="setStarRating()" />
    <?php for ($i = 1; $i <= 4; $i++) : ?>
      <span class="icon">★</span>
    <?php endfor; ?>
  </label>
  <label>
    <input type="radio" name="star" value="5" onclick="setStarRating()" />
    <?php for ($i = 1; $i <= 5; $i++) : ?>
      <span class="icon">★</span>
    <?php endfor; ?>
  </label>
</div>

<script>
  function setStarRating() {
    let rating = document.querySelector('.star-rating input[name="rating"]');
    rating.value = event.target.value;
  }
</script>