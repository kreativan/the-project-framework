<?php
/**
 * Use valitron lib to validate forms
 */

$v = tpf_valitron($_POST);
$v->rule('required', ["name", "email"]); 
$v->rule('email', ["email"]);

$labels_array = [
  "name" => "Your Name",
  "email" => "Your Email",
];

$v->labels($labels_array);

if(!$v->validate()) {

  // get errors from valitron and store them in errors array
  $errors = [];
  $errors_fields = [];
  
  foreach($v->errors() as $key => $value) {
    $errors[] = $value[0]; 
    $errors_fields[] = $key;
  }

}