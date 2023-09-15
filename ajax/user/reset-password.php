<?php

$response = [
  'errors' => [],
  'error_fields' => [],
  'POST' => [
    'rp_key' => '(string) Reset password key',
    'rp_login' => '(string) Reset password login',
    'pass1' => '(string) Password',
    'pass2' => '(string) Password confirmation',
  ],
];

$rp_key = $_REQUEST['rp_key'];
$rp_login = $_REQUEST['rp_login'];

$user = check_password_reset_key($rp_key, $rp_login);

if (!$user || is_wp_error($user)) {
  $response['errors'] = $user->get_error_messages();
}

if (empty($_POST['pass1'])) {
  $response['errors'][] = __('Password is required', 'the-project-framework');
  $response['error_fields'][] = "pass1";
}

if ($_POST['pass1'] != $_POST['pass2']) {
  $response['errors'][] = __('Passwords do NOT match', 'the-project-framework');
  $response['error_fields'] = ["pass1", "pass2"];
}

if (count($response['errors']) < 1) {
  reset_password($user, $_POST['pass1']);
  $response['modal'] = __("Success! Your password has been updated", 'the-project-framework');
  $response['redirect'] = tpf_user_page('url');
}

header('Content-type: application/json');
echo json_encode($response);
exit();
