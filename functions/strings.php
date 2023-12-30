<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 *  Replace {my_field} with $_POST['my_field'] or any data array
 *  Or {my_field} with any array data ['my_field' => 'The Project']
 */
function TPF_STR_Replace($string, $data = []) {
  $string = !empty($string) ? $string : "";
  preg_match_all("/\{(.*?)\}/", $string, $matches);
  foreach ($matches[1] as $key) {
    $replace = sanitize_text_field($data[$key]);
    $string = str_replace("{" . $key . "}", $replace, $string);
  }
  return $string;
}

/**
 *  Limit number of chars in a string
 *  @param string $str
 *  @param int $limit
 *  @return string
 */
function TPF_Short_Text($str, $limit = 100) {
  if (strlen($str) > $limit) {
    return substr($str, 0, $limit) . "...";
  }
  return $str;
}

/**
 *  Limit number of words in a string
 *  @param string $text
 *  @param int $limit
 *  @return string
 */
function TPF_Word_limit($text, $limit) {
  if (str_word_count($text, 0) > $limit) {
    $words = str_word_count($text, 2);
    $pos = array_keys($words);
    $text = substr($text, 0, $pos[$limit]) . '...';
  }
  return $text;
}
