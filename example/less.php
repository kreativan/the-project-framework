<?php
/**
 * Using less compiler
 */

$lessCompiler = new Less_Compiler;

$less_files = [
  get_template_directory() . "/lib/uikit/src/less/uikit.theme.less",
];

$less_vars = [
  "global-font-family" => "'Roboto Flex', sans-serif",
  "base-heading-font-family" => "'Roboto Flex', sans-serif",
];

$dev_mode = 1;

// this wil give you the link of css file to use in src tag
$src = $lessCompiler->less($less_files, $less_vars, "main", $dev_mode);

?>

<link rel="stylesheet" type="text/css" href="<?= $src ?>">