<?php

/**
 * Add to cart
 * Based on woocommerce default add to cart function "?add-to-cart=123"
 * We just set the response so we can update UI and use it in our ajax request
 * @var $_GET['add-to-cart']
 * @example /ajax/woo/?add-to-cart=123
 */

$response = [
  "GET" => [
    "add-to-cart" => "(int) Product ID"
  ]
];

if (!isset($_GET['add-to-cart'])) {
  $response['status'] = 'error';
  $response['message'] = __('Product ID is missing', 'the-project-framework');
  jsonResponse($response);
}

// Get product based on "add-to-cart" id
$id = $_GET['add-to-cart'];
$product = wc_get_product($id);

// Set Response
$response['status'] = 'success';
// $response['message'] = $product->get_name() . ' has been added to your cart. ';
$response['message'] = sprintf(__('%s has been added to your cart.', 'the-project-framework'), $product->get_name());
$response['cart_count'] = WC()->cart->get_cart_contents_count();

// Clear woocommerce cart notices
wc_clear_notices();

jsonResponse($response);
exit();
