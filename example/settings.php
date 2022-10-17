<?php
/**
 *  Add new setting to the Setings > The Project
 */
new The_Project_Settings_Field([
  "name" => "my_field",
  "title" => "My Field"
  "type" => "radio", // text, email, password, number, radio, select 
  "options" => ["one" => "1", "two" => "2"]
])