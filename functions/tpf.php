<?php

function dump($var) {
  echo '<pre>',print_r($var,1),'</pre>';
}


/**
 * Project info and developer settings
 * @param string $field
 */
function the_project($field = "") {

  $arr = get_option('project_settings');
  
  if($field != "") {
    return isset($arr[$field]) ? $arr[$field] : "";
  } else {
    return $arr;
  }

}

/**
 * Site settings defined in ACF options
 */
function site_settings($field) {
  if(function_exists("get_field")) {
    $value = get_field("$field", 'options');
    return !empty($value) ? $value : false;
  }
}
