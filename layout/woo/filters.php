<?php

/**
 * layout: woo/filters
 */

$i = 0;

$search_filters = new \TPF\SearchFilters;
$filters = $search_filters->filters();

if (is_product_category()) {
  // get current category 
  $page = get_queried_object();
  $url = get_term_link($page);
} else {
  $url = get_permalink(wc_get_page_id('shop'));
}
?>

<form action="<?= $url ?>" method="GET" <?= htmx_form('change') ?>>

  <?php foreach ($filters as $filter) :
    $filter_type = $filter['type'];
    $filter_name = $filter['name'];
  ?>
    <div class="uk-margin">
      <h3 class="uk-h5 uk-text-uppercase uk-text-bold uk-margin-small">
        <?= $filter['title'] ?>
      </h3>
      <?php if ($filter_type == "select") : ?>
        <div>
          <select class="uk-select uk-form-small" name="<?= $filter_name ?>">
            <?php foreach ($filter['items'] as $label => $item) :
              $selected = isset($_GET[$filter_name]) && $_GET[$filter_name] == $item['value'] ? "selected" : '';
            ?>
              <option value="<?= $item['value'] ?>" <?= $selected ?>>
                <?= $label ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      <?php else : ?>
        <?php foreach ($filter['items'] as $label => $item) : ?>
          <div>
            <?php if ($filter_type == "checkbox") :
              $name = $item['name'];
              $value = $item['value'];
              $checked = isset($_GET[$name]) && !empty($_GET[$name]) ? " checked" : '';
            ?>
              <label class="uk-form-label">
                <input type="checkbox" name="<?= $name ?>" value="<?= $value ?>" <?= $checked ?> />
                <span class="uk-margin-small-left">
                  <?= $label ?>
                </span>
              </label>
            <?php elseif ($filter_type == "radio") :
              $checked = isset($_GET[$filter_name]) && $_GET[$filter_name] == $item['value'] ? " checked" : '';
            ?>
              <label class="uk-form-label">
                <input type="radio" name="<?= $filter_name ?>" value="<?= $item['value'] ?>" <?= $checked ?> />
                <span class="uk-margin-small-left">
                  <?= $label ?>
                </span>
              </label>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</form>