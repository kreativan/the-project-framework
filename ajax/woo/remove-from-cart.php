<?php

/**
 * Remove product from cart
 * @var int $_GET['product_id']
 * @var int $_GET['key']
 */

$response = [
  'GET' =>  [
    'product_id' => '(int) Product ID',
    'key' => '(string) Cart item key',
  ],
];

$key = isset($_GET['key']) ? $_GET['key'] : false;
$id = isset($_GET['product_id']) ? $_GET['product_id'] : false;

if (!$key || !$id) {
  $response['status'] = 'error';
  $response['message'] = 'Invalid request';
  header('Content-type: application/json');
  echo json_encode($response);
  exit();
}

// Get the product
$product = wc_get_product($id);

// remove product from cart
WC()->cart->remove_cart_item($key);

// set response
$response['status'] = 'success';
// $response['message'] = $product->get_name() . ' has been removed from cart. ';
$response['message'] = sprintf(__('%s has been removed from cart', 'the-project-framework'), $product->get_name());
$response['cart_count'] = WC()->cart->get_cart_contents_count();

// Clear woocommerce cart notices
wc_clear_notices();

// htmx response
$response['htmx'] = [
  'url' => './?htmx=layout/woo/cart-table',
  'type' => 'GET',
  'target' => '#woo-cart-items',
  'swap' => 'innerHTML',
];

jsonResponse($response);
exit();
