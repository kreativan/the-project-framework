<?php

// ---------------------------------------------------------
// JSON
// ---------------------------------------------------------

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

//--------------------------------------------------------
//  Numbers
//--------------------------------------------------------

/**
 * Check if number is even or odd
 * @param int $number
 * @return string
 */
function even_odd($number) {
  if ($number % 2 == 0) {
    return "even";
  } else {
    return "odd";
  }
}

/**
 *  Add Percent to a number
 *  sum = n + (( p / 100) * n )
 *  @param int $number
 *  @param int $percent
 *  @return int
 */
function add_percent($number, $percent) {
  $sum = $number + (($percent / 100) * $number);
  return $sum;
}


// --------------------------------------------------------- 
// Strings 
// --------------------------------------------------------- 

/**
 *  Replace {my_field} with $_POST['my_field']
 *  Or {my_field} with any array data ['my_field' => 'The Project']
 */
function tpf_str_replace($string, $data = []) {
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
function short_text($str, $limit = 100) {
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
function word_limit($text, $limit) {
  if (str_word_count($text, 0) > $limit) {
    $words = str_word_count($text, 2);
    $pos = array_keys($words);
    $text = substr($text, 0, $pos[$limit]) . '...';
  }
  return $text;
}


// --------------------------------------------------------- 
// Date & Time 
// --------------------------------------------------------- 

function time_ago($timestamp) {
  if (is_string($timestamp)) $timestamp = strtotime($timestamp);
  $ago = human_time_diff($timestamp, time());
  return sprintf(__x("%s ago"), $ago);
}

// --------------------------------------------------------- 
// Validation 
// --------------------------------------------------------- 

function tpf_valitron($lang = "en") {
  if ($lang == "") {
    $lang = get_option('WPLANG');
    $lang = explode("_", $lang);
    $lang = $lang[0];
    $lang = !empty($lang) ? $lang : 'en';
  }
  require_once tpf_dir() . "lib/valitron/src/Valitron/Validator.php";
  Valitron\Validator::lang($lang);
  $v = new Valitron\Validator($array);
  return $v;
}
