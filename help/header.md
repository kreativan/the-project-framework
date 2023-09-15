# Header

```php
<?php

$TPF = new \TPF\TPF();

// Dev mode
$dev_mode = the_project('dev_mode') == '1' ? true : false;

// Less files
$less = [
  $TPF->path() . "lib/less/default.less",
  get_template_directory() . "/less/vars.less",
  get_template_directory() . "/less/style.less",
];

// less vars
$less_vars = [
  'global-font-family' => 'Inter',
];

// css files
$css_files = [
  get_template_directory_uri() . "/assets/fonts/inter.css",
];

// js files
$js_files = [
  $TPF->url() . "lib/uikit/dist/js/uikit-core.min.js",
  $TPF->url() . "lib/uikit/dist/js/uikit-icons.min.js",
  $TPF->url() . "lib/uikit/dist/js/components/notification.min.js",
  $TPF->url(). "lib/uikit/dist/js/components/lightbox.min.js",
];

// js vars
$js_vars = [
  "debug" => $dev_mode ? true : false,
  "ajaxUrl" => tpf_ajax_url(),
];

?>

<!DOCTYPE html>
<html lang="<?= site_lang() ?>">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <?php
  /** TPF head */
  tpf_render("layout/base/head", [
    "less_files" => $less,
    "less_vars" => $less_vars,
    'css_files' => $css_files,
    "js_files" => $js_files,
    "js_vars" => $js_vars,
    // 'google_fonts_link' => "https://fonts.googleapis.com/css2?family=Jost:wght@300;400;700&display=swap",
  ]);

  /** WP head */
  wp_head();
  ?>

</head>

<body>

  <?php
  // tpf_render("layout/base/mobile-header");
  ?>

  <?php
  // tpf_render("layout/base/header");
  ?>

  <main id="main">
    <!-- main start -->
```
