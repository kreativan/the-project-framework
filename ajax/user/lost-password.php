<?php
$response = [
  'errros' => [],
];

/**
 * Checks the data and prepares the user's account for password reset by creating the reset WP password token 
 * and emailing it to the user.
 */
$errors = retrieve_password();

if (is_wp_error($errors)) {

  $response['errors'] = $errors->get_error_messages();
} else {

  $response['status'] = 'success';
  $response['notification'] = __('Success! Please check your email.', 'the-project-framework');
}


header('Content-type: application/json');
echo json_encode($response);
exit();
