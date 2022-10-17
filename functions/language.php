<?php
/**
 * Multilanguage strings
 * @param string $str
 * if specified $str does not exists it will be added to translation file
 * using lng_update() function
 * @example lng('Read More');
 */
function lng($str = "") {

  $key = lng_key($str);

  $lang = get_option('WPLANG');
  $lang = explode("_", $lang);
  $lang = $lang[0];
  $lang = !empty($lang) ? $lang : 'en';

  $default_file = get_template_directory() . "/assets/language/default.json";
  $default_json = file_get_contents($default_file);
  $default = json_decode($default_json, true);

  if(!isset($default[$key])) lng_update($str);

  $translation_file = get_template_directory() . "/assets/language/$lang.json";
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