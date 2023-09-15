<?php

/**
 * ajax: woo/review-submit
 * @var string $_POST['review']
 * @var int $_POST['product_id']
 * @var int $_POST['rating']
 */

$response = [
  'POST' => [
    'review' => '(string) Review',
    'product_id' => '(int) Product ID',
    'rating' => '(int) Rating',
  ],
];

$is_rating_req = get_option('woocommerce_review_rating_required');

$errors = [];

$product_id = (int) $_POST['product_id'];
$review = sanitize_textarea_field($_POST['review']);
$rating = (int) $_POST['rating'];
$current_user = wp_get_current_user();

if (empty($review) || $review == "") {
  $errors[] = __('Review cannot be empty.', 'the-project-framework');
}

if ($is_rating_req == "yes" && (!$rating || empty($rating) || $rating == "" || $rating < 1)) {
  $errors[] = __('Rating is required.', 'the-project-framework');
}

if (count($errors) > 0) {
  $response['status'] = 'error';
  $response['errors'] = $errors;
  jsonResponse($response);
}


// review data
$review_data = array(
  'comment_post_ID' => $product_id,
  'comment_author' => $current_user->user_login,
  'comment_author_email' => $current_user->user_email,
  'comment_content' => $review,
  'comment_type' => 'review',
  'comment_approved' => 0,
  'comment_meta' => array(
    'rating' => $rating,
  ),
);

$review_id = wp_insert_comment($review_data);

if (!is_wp_error($review_id)) {
  $response = [
    'status' => 'success',
    'modal' => __('Review submitted successfully.', 'the-project-framework'),
  ];
} else {
  $response = [
    'status' => 'error',
    'notification' => __('Something went wrong.', 'the-project-framework'),
  ];
}

jsonResponse($response);
