<?php

/**
 * layout: woo/filters
 */

$i = 0;

$woo_query = new \TPF\Woo_Query;
$filters = $woo_query->filters();

if (is_product_category()) {
  // get current category 
  $page = get_queried_object();
  $url = get_term_link($page);
} else {
  $url = get_permalink(wc_get_page_id('shop'));
}
?>

<form action="<?= $url ?>" method="GET" <?= htmx_form('change') ?>>

  <?php foreach ($filters as $label => $item) :
    $name = $item['name'];
    $value = $item['value'];
    $checked = isset($_GET[$name]) && !empty($_GET[$name]) ? " checked" : '';
  ?>
    <div>
      <label class="uk-form-label">
        <input type="checkbox" name="<?= $name ?>" value="<?= $value ?>" <?= $checked ?> />
        <span class="uk-margin-small-left">
          <?= $label ?>
        </span>
      </label>
    </div>
  <?php endforeach; ?>
</form>