<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Init Valitron
 * @param array $array
 * @param string $lang
 */
function TPF_Valitron_Init($array, $lang = "en") {
  require_once tpf_dir() . "lib/valitron/src/Valitron/Validator.php";
  if ($lang == "") {
    $lang = get_option('WPLANG');
    $lang = explode("_", $lang);
    $lang = $lang[0];
    $lang = !empty($lang) ? $lang : 'en';
  }
  Valitron\Validator::lang($lang);
  $v = new Valitron\Validator($array);
  return $v;
}

/**
 * Valitron Basic
 * @param array $array
 * @param string $lang
 */
function TPF_Valitron($array, $lang = "en") {
  return TPF_Valitron_Init($array, $lang);
}

/**
 * Validate POST data using TPF_Valitron_Init @method
 * @param array $params
 * @param string $lang
 * @return array|bool false if POST is valid - array of errors if not
 * 
 * @example
 * $errors = TPF_Valitron_REQ_Errors([
 *  'labels' => ['name' => 'Your Name', 'email' => 'Your Email'],
 *  'required' => ['name', 'email'],
 *  'email' => ['email' ],
 *  'integer' => ['age', 'days'],
 * ], 'en');
 * if (!$errors) // is valid
 */
function TPF_Valitron_REQ_Errors($params = [], $lang = 'en') {

  $labels = !empty($params['labels']) ? $params['labels'] : [];
  $required = !empty($params['required']) ? $params['required'] : []; // field names

  // exclude from dynamic rules
  $exc = ['labels', 'required'];

  $v = TPF_Valitron_Init($_REQUEST, $lang);
  $v->labels($labels);
  $v->rule('required', $required);

  // add all params except excluded as rules
  foreach ($params as $key => $array) {
    if (!in_array($key, $exc)) {
      $v->rule($key, $array);
    }
  }

  if (!$v->validate()) {
    return $v->errors();
  } else {
    return false;
  }
}
