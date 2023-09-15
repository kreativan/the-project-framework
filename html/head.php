<?php

/**
 * html: Head
 * should be included in the <head> tag
 */

// Meta
if (the_project('seo')) {
  tpf_include("html/meta");
}

// Less compiler
$less = new Less_Compiler;

// Dev mode
$dev_mode = the_project('dev_mode') == '1' ? true : false;

// Less files 
$less_files = !empty($less_files) ? $less_files : [];

// Less vars
$less_vars = !empty($less_vars) ? $less_vars : [];

// JS Files
$js_files = !empty($js_files) ? $js_files : [];

/**
 * JS Vars
 * JS variables exposed console.log(cms.debug)
 */
$js_vars = !empty($js_vars) ? $js_vars : [];

/**
 * CSS Files
 * array of css files to load in <head>
 */
$css_files = !empty($css_files) ? $css_files : [];


/**
 * Google Fonts
 * Google Fonts CDN link
 */
$google_fonts_link = !empty($google_fonts_link) ? $google_fonts_link : "";

?>

<?php if ($google_fonts_link && $google_fonts_link != "") : ?>
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="style" href="<?= $google_fonts_link ?>">
  <link href="<?= $google_fonts_link ?>" rel="stylesheet">
<?php endif; ?>

<!-- preload main css -->
<?php if (!$dev_mode) : ?>
  <link rel="preload" href="<?= get_template_directory_uri() . "/assets/css/main.css"; ?>" as="style">
<?php endif; ?>

<!-- preload css -->
<?php if (count($css_files) > 0) : ?>
  <?php foreach ($css_files as $css_file) : ?>
    <link rel="preload" href="<?= $css_file ?>" as="style">
  <?php endforeach; ?>
<?php endif; ?>

<!-- main css/less -->
<link rel="stylesheet" type="text/css" href="<?= $less->less($less_files, $less_vars, "main", $dev_mode); ?>">

<!--styles -->
<?php if (count($css_files) > 0) : ?>
  <?php foreach ($css_files as $css_file) : ?>
    <link rel="stylesheet" type="text/css" href="<?= $css_file ?>">
  <?php endforeach; ?>
<?php endif; ?>

<!-- Scripts -->
<?php foreach ($js_files as $file) : ?>
  <script defer type='text/javascript' src='<?= $file ?>'></script>
<?php endforeach; ?>

<!-- JS Vars -->
<script>
  const cms = <?= json_encode($js_vars) ?>;
  const pw = <?= json_encode($js_vars) ?>;
  <?php if ($dev_mode) : ?>
    console.log(cms);
  <?php endif; ?>
</script>

<?php
do_action("tpf_head");
?>