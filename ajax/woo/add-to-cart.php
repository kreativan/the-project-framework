<?php

$response = [
  "status" => "success",
  "message" => "Product has been added to the cart",
  'GET' =>  $_GET,
];

$id = $_GET['add-to-cart'];
$product= wc_get_product( $id );
$response['message'] = $product->get_name() . ' has been added to your cart. ';
$response['cart_count'] = WC()->cart->get_cart_contents_count();

// Clear woocommerce cart notices
wc_clear_notices();

header('Content-type: application/json');
echo json_encode($response);
exit();