<?php

/**
 * Login user with ajax post request
 */

$response = [
  'errors' => [],
  'POST' => [
    'user_login' => '(string) Username or email',
    'user_password' => '(string) Password',
    'remember' => '(bool) Remember me',
  ],
];


//-------------------------------------------------------- 
//  Validation
//-------------------------------------------------------- 

$user_login     = esc_attr($_POST["user_login"]);
$user_password  = esc_attr($_POST["user_password"]);
$remember = isset($_POST["remember"]) && $_POST["remember"] == 1 ? true : false;

$login_data = [
  'user_login'    => $user_login,
  'user_password' => $user_password,
  'remember'      => $remember,
];

$user = wp_signon($login_data, false);

if (is_wp_error($user)) {

  $response['errors'] = $user->get_error_messages();

  header('Content-type: application/json');
  echo json_encode($response);
  exit();
}


//-------------------------------------------------------- 
//  Login
//-------------------------------------------------------- 

wp_set_current_user($user->ID, $user_login);
wp_set_auth_cookie($user->ID, true, false);
do_action('wp_login', $user_login);

$response['redirect'] = tpf_user_page('url');

header('Content-type: application/json');
echo json_encode($response);
exit();
