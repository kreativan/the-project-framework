<?php

$response = [
  "status" => "success",
  "message" => "Product has been added to the cart",
  'GET' =>  $_GET,
];

$key = $_GET['remove_item'];
$id = $_GET['id'];
$product = wc_get_product( $id );

// remove product from cart
WC()->cart->remove_cart_item( $key );

// set response
$response['message'] = $product->get_name() . ' has been removed from cart. ';
$response['cart_count'] = WC()->cart->get_cart_contents_count();

WC()->cart->remove_cart_item( $cart_item_key );
// Clear woocommerce cart notices
wc_clear_notices();

// htmx response
$response['htmx'] = [
  'url' => '/htmx/layout/woo/cart-list/',
  'type' => 'GET',
  'target' => '#offcanvas-cart-list',
  'swap' => 'innerHTML',
];

header('Content-type: application/json');
echo json_encode($response);
exit();