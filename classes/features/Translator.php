<?php

class TPF_Translator {

  public function __construct() {

    // $this->TPF = new \TPF\TPF();

    $dir = WP_CONTENT_DIR . "/translator/";
    $this->json_dir = $dir;
    $this->json_file = "{$dir}translator.json";

    if (!file_exists($dir) || !is_dir($dir)) mkdir($dir);
  }

  //--------------------------------------------------------
  // Scan & Save
  //--------------------------------------------------------

  public function save($POST, $locale) {
    $json = json_encode($POST);
    $target = $this->json_dir . "translator-{$locale}.json";
    file_put_contents($target, $json);
  }

  public function scan() {
    $strings = $this->strings();
    $json_data = json_encode($strings);
    file_put_contents($this->json_file, $json_data);
  }

  //--------------------------------------------------------
  //  Utility
  //--------------------------------------------------------

  public function encode($string) {
    return sanitize_key($string);
  }

  public function defaults($string = '') {
    if (!file_exists($this->json_file)) return [];
    $json = file_get_contents($this->json_file);
    $array = json_decode($json, true);
    return $string != '' ? $array[$string] : $array;
  }

  public function value($string = '', $locale = '') {

    $locale = $locale != '' ? $locale : get_locale();
    $locale_arr = [];
    $default_arr = [];

    $locale_file = $this->json_dir . "translator-$locale.json";
    if (file_exists($locale_file)) {
      $locale_json = file_get_contents($locale_file);
      $locale_arr = json_decode($locale_json, true);
    }

    $default_json = file_get_contents($this->json_file);
    $default_arr = json_decode($default_json, true);

    $string = $this->encode($string);

    return isset($locale_arr[$string]) ? $locale_arr[$string] : $default_arr[$string];
  }

  //--------------------------------------------------------
  // Core
  //--------------------------------------------------------

  public function strings() {
    $array = [];
    $files = $this->get_files();
    foreach ($files as $file) {
      if (file_exists($file)) {
        $strings = $this->find_strings($file);
        if (isset($strings[3]) && count($strings[3]) > 0) {
          foreach ($strings[3] as $str) {
            $array[$this->encode($str)] = $str;
          }
        }
      }
    }
    return $array;
  }

  public function get_files() {
    $array = [];
    $dirs = $this->get_dirs();
    foreach ($dirs as $dir) {
      $files = glob($dir . '/*.php');
      if (count($files) > 0) {
        $array = array_merge($array, $files);
      }
    }
    return $array;
  }

  public function get_dirs() {
    $array = [];
    $template_dir = get_template_directory() . "/";
    $root = array_filter(glob($template_dir . '*'), 'is_dir');
    $subfolders = array_filter(glob($template_dir . '**/*'), 'is_dir');

    $lvl2 = array_filter(glob($template_dir . '**/**/*'), 'is_dir');
    $lvl3 = array_filter(glob($template_dir . '**/**/**/*'), 'is_dir');

    $array = array_merge($array, $root);
    $array = array_merge($array, $subfolders);
    if (count($lvl2) > 0) {
      $array = array_merge($array, $lvl2);
    }

    if (count($lvl3) > 0) {
      $array = array_merge($array, $lvl3);
    }

    if (the_project('translator_plugin_dir_scan')) {

      $tpf_path = $this->TPF->path();
      $tpf_dir = array_filter(glob($tpf_path . '*'), 'is_dir');
      $tpf_dir2 = array_filter(glob($tpf_path . '**/*'), 'is_dir');
      $tpf_dir3 = array_filter(glob($tpf_path . '**/**/*'), 'is_dir');

      $array = array_merge($array, $tpf_dir);

      if (count($tpf_dir2) > 0) {
        $array = array_merge($array, $tpf_dir2);
      }

      if (count($tpf_dir3) > 0) {
        $array = array_merge($array, $tpf_dir3);
      }
    }

    return $array;
  }

  /**
   *  Find all translatable strings in a file
   *  @param string $file
   */
  public function find_strings($file) {
    $matches = [];
    if (!is_file($file)) {
      return $matches;
    }

    $data = file_get_contents($file);
    // Find __('text', textdomain) style matches
    preg_match_all(
      '/([\s.=(]__x|^__)\(\s*' . // __(
        '([\'"])(.+?)(?<!\\\\)\\2\s*' . // "text"
        '(?:,\s*[^)]+)?\)+(.*)$/m', // , textdomain (optional) and everything else
      $data,
      $matches
    );
    return $matches;
  }
}
