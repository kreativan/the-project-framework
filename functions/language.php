<?php
/**
 * Multitranslatoruage strings
 * @param string $str
 * if specified $str does not exists it will be added to translation file
 * using lng_update() function
 * @example lng('Read More');
 */
function lng($str = "") {

  $key = lng_key($str);

  $translator = get_option('WPtranslator');
  $translator = explode("_", $translator);
  $translator = $translator[0];
  $translator = !empty($translator) ? $translator : 'en';

  $default_file = get_template_directory() . "/assets/language/default.json";
  $default_json = file_get_contents($default_file);
  $default = json_decode($default_json, true);

  if(!isset($default[$key])) lng_update($str);

  $translation_file = get_template_directory() . "/assets/language/$translator.json";
  if(file_exists($translation_file)) {
    $translation_json = file_get_contents($translation_file);
    $translation = json_decode($translation_json, true);
    if(isset($translation[$key])) return $translation[$key];
  }

  return isset($default[$key]) ? $default[$key] : $str;
}

/**
 * Add specified string to the translate file
 * @param string $str
 */
function lng_update($str) {
  $key = lng_key($str);
  $file = get_template_directory() . "/assets/language/default.json";
  $json = file_get_contents($file);
  $array = json_decode($json, true);
  $array[$key] = $str;
  file_put_contents($file, json_encode($array));
}

/**
 * Encode string to inpu name
 * for use in lng() and lng_update() functions
 * @param string $str
 */
function lng_key($str) {
  $key = strtolower($str);
  $key = str_replace(" ", "_", $key);
  $key = str_replace(".", "", $key);
  $key = str_replace("'", "", $key);
  $key = str_replace('"', "", $key);
  $key = str_replace("%s", "__s__", $key);
  return $key;
}

/**
 * language function
 */
function __x($string, $locale = "") {
  $locale = $locale != "" ? $locale : get_locale();
  $dir = WP_CONTENT_DIR . "/translator/";
  $default_file = "{$dir}translator.json";
  $locale_file = "{$dir}translator-$locale.json";
  if (!file_exists($default_file) && !file_exists($locale_file)) return $string;
  $json_file = file_exists($locale_file) ? $locale_file : $default_file;
  $json = file_get_contents($json_file);
  $array = json_decode($json, true);
  $key = sanitize_key($string);
  return isset($array[$key]) ? $array[$key] : $string;
}