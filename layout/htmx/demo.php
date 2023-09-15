<?php

/**
 * Demo: htmx
 */

namespace ProcessWire;

// Data for HTMX Req
$htmx_demo_data = [
  "trigger" => "revealed",
  "target" => "#init-container",
  "swap" => "innerHTML",
  "vals" => [
    "cms" => "ProcessWire",
    "framework" => "Wirekit",
    "ui" => "UIkit",
  ],
];

?>

<div class="uk-container tm-container-margin" uk-height-viewport="expand: true">

  <h1>HTMX Demo</h1>

  <div id="init-container" <?= htmx('components/htmx-demo/init.php', $htmx_demo_data) ?>></div>

  <div id="demo-container" class="uk-margin-top"></div>

</div>