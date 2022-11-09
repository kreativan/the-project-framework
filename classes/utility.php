<?php

class TPF_Utility {

  /**
   *  Validate Data/Form with Valitron
   *  @param array $array
   *  @example 
   *  $v = tpf_valitron($_POST);
   *  $v = $v->rule('email', 'email');
   *  if ( !$v->validate() ) print_r( $v->errors() );
   */
  public function valitron($array, $lang = "") {

    // Site language
    if($lang == "") {
      $lang = get_option('WPLANG');
      $lang = explode("_", $lang);
      $lang = $lang[0];
      $lang = !empty($lang) ? $lang : 'en';
    }

    require_once(__DIR__."/../lib/valitron/src/Valitron/Validator.php");
    Valitron\Validator::lang($lang);
    $v = new Valitron\Validator($array);
    return $v;
  }

  //-------------------------------------------------------- 
  //  Text
  //-------------------------------------------------------- 

  /**
   *  Replace {my_field} with $_POST['my_field']
   *  Or {my_field} with any array data ['my_field' => 'The Project']
   */
  public function str_replace($string, $data = []) {
    preg_match_all("/\{(.*?)\}/", $string, $matches);
    foreach($matches[1] as $key) {
      $replace = sanitize_text_field($data[$key]);
      $string = str_replace("{".$key."}", $replace, $string);
    }
    return $string;
  }

  /**
  *  Limit number of chars in a string
  *  @param string $str
  *  @param int $limit
  *  @return string
  */
  public function short_text($str, $limit = 100) {
    if(strlen($str) > $limit) return substr($str, 0, $limit) . "...";
    return $str;
  }

  /**
   *  Limit number of words in a string
   *  @param string $text
   *  @param int $limit
   *  @return string
   */
  public function word_limit($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
      $words = str_word_count($text, 2);
      $pos = array_keys($words);
      $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
  }

  //-------------------------------------------------------- 
  //  Numbers
  //-------------------------------------------------------- 

  /**
  * Check if number is even or odd
  * @param int $number
  * @return string 
  */
  public function even_odd($number) {
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
  public function add_percent($number, $percent) {
    $sum = $number + (($percent/100) * $number);
    return $sum;
  }

}