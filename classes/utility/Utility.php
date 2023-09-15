<?php

/**
 * Utility
 * Various methods
 */

namespace TPF;

class Utility {

  // --------------------------------------------------------- 
  // ACF 
  // --------------------------------------------------------- 

  /**
   * Init local acf field group
   * by including file from template or tpf folder.
   * Local field groups are saved as json files in lib/acf/ and theme/acf folders
   */
  function acf_group_init($file_name) {
    if (substr($file_name, -4) != ".php") $file_name = $file_name . ".php";
    $tmpl = get_template_directory() . "/acf/$file_name";
    $plg = tpf_path() . "lib/acf/$file_name";
    $file = file_exists($tmpl) ? $tmpl : $plg;
    include_once($file);
  }

  //--------------------------------------------------------
  //  Strings
  //--------------------------------------------------------

  /**
   *  Replace {my_field} with $_POST['my_field']
   *  Or {my_field} with any array data ['my_field' => 'The Project']
   */
  public function str_replace($string, $data = []) {
    preg_match_all("/\{(.*?)\}/", $string, $matches);
    foreach ($matches[1] as $key) {
      $replace = sanitize_text_field($data[$key]);
      $string = str_replace("{" . $key . "}", $replace, $string);
    }
    return $string;
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
    $sum = $number + (($percent / 100) * $number);
    return $sum;
  }

  //-------------------------------------------------------- 
  //  Time
  //-------------------------------------------------------- 

  public function time_ago($timestamp) {
    if (is_string($timestamp)) $timestamp = strtotime($timestamp);
    $ago = human_time_diff($timestamp, time());
    return sprintf(__x("%s ago"), $ago);
  }


  // --------------------------------------------------------- 
  // Validation 
  // --------------------------------------------------------- 

  public function valitron($lang = "en") {
    if ($lang == "") {
      $lang = get_option('WPLANG');
      $lang = explode("_", $lang);
      $lang = $lang[0];
      $lang = !empty($lang) ? $lang : 'en';
    }
    require_once __DIR__ . "/../../lib/valitron/src/Valitron/Validator.php";
    Valitron\Validator::lang($lang);
    $v = new Valitron\Validator($array);
    return $v;
  }

  // --------------------------------------------------------- 
  // File & Folders 
  // --------------------------------------------------------- 

  /**
   * List all files in a folder and subfolders
   * excluding files starting with _
   * @param string $dir
   * @return array
   */
  public function get_files($path, $exclude_ext = []) {
    $files = [];
    // Get all subdirectories
    $dirs = glob($path . '*', GLOB_ONLYDIR);
    // Loop through each subdirectory
    foreach ($dirs as $dir) {
      // Get all files in the subdirectory
      $subfiles = glob($dir . '/*');
      // Loop through each file
      foreach ($subfiles as $file) {
        // Get the file extension
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        // If the file extension is not the one to exclude, add it to the files array
        if (!in_array($ext, $exclude_ext)) {
          $files[] = $file;
        }
      }
    }
    return $files;
  }
}
