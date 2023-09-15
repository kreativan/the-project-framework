<?php

/**
 *  layout: woo/product-single-price
 *  @var object $product
 */

$currency_symbol = get_woocommerce_currency_symbol();

$sale_to = !empty($product->get_date_on_sale_from()) ? strtotime($product->get_date_on_sale_to()) : '';
$sale_date = ($sale_to != '') ? date('d F Y h:s:i', $sale_to) : '';

$arr = [
  "regular_price" => [
    'label' => __('Regular Price: ', 'woocommerce'),
    'value' => !empty($product->get_sale_price()) ? $product->get_regular_price() : '',
    "currency" => true,
  ],
  "sale_price" => [
    'label' => __('Sale Price: ', 'woocommerce'),
    'value' => $product->get_sale_price(),
    "currency" => true,
  ],
  "sale_date" => [
    'label' => __('Sale End: ', 'woocommerce'),
    'value' => $sale_date,
    "currency" => false,
  ],
];

?>

<?php if (!empty($product->get_sale_price())) : ?>
  <ul class="uk-list uk-list-divider uk-text-small">
    <?php foreach ($arr as $item) : ?>
      <?php if (!empty($item['value'])) :
        $curency = $item['currency'] ? " $currency_symbol" : '';
      ?>
        <li>
          <span class="uk-text-empahsis"><?= $item['label'] ?></span>
          <span><?= $item['value'] ?> <?= $curency ?></span>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>