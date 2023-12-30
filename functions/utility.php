<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Encode json
 * ready to be used in HTML attributes
 * @param array $data
 */
function jsonEncode($data) {
  return htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Decode Json File
 * @param string $file
 * @param bool $arr - return array or object
 * @return array|object
 */
function jsonDecodeFile($file, $arr = true) {
  $json = file_get_contents($file);
  return json_decode($json, $arr);
}

/**
 * Echo json response
 * @param array $response
 */
function jsonResponse($response) {
  header('Content-type: application/json');
  echo json_encode($response);
  exit();
}
