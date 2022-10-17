<?php
$response = [
  // used also for notification color
  "status" => "pending",
  // clear-reset form input values
  "reset_form" => false, 
  // response message
  "message" => "Some response message",
  // Notification, will trigger uikit notification
  "notification" => "Notification: Ajax form submit was ok!",
  // Will trigger modal on response, has priority over notification
  "modal" => "<h3>Title</h3><p>text</p>", 
  // Same as 'modal'. Will trigger modal response, has priority over notification
  "alert" => "<h3>Title</h3><p>text</p>", 
  // Will trigger dialog on response
  "dialog" => "<iframe src=''></iframe>", 
  // Set modal dialog width
  "modal_width" => "1200px",
  // Specify modal css ID that you want to remove on response
  "close_modal_id" => "htmx-modal",
  // Redirect after respone. If used with modal, will redirect after modal confirm... 
  "redirect" => "/",
  // Open new browser tab after response
  "open_new_tab" => "example.com",
  // array of errors (strings), will trigger notification for each
  "errors" => [],
  // array of names for invalid fields
  "error_fields" => [], 
  // Will trigger htmx request on response
  "htmx" => [
    "type" => "GET",
    "url" => "/",
    "target" => "#target-elemnt",
    "swap" => "innerHTML",
    "indicator" => "#htmx-indicator",
    "push_url" => "./",
  ],
  // Log $_POST data
  "post" => $_POST,
  // Log $_GET data
  "get" => $_GET,
  // log request data
  "REQUEST" => $_REQUEST,
];

header('Content-type: application/json');
echo json_encode($response);
exit();