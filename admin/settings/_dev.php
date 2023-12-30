<?php

if (!defined('ABSPATH')) {
  exit;
}

$dev = [
  "dev_mode" => [
    "type" => "radio",
    "label" =>  "Dev Mode",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "1",
    "description" => "Less compiler, assets cache busting..."
  ],
  "project_js" => [
    "type" => "radio",
    "label" =>  "Project.js",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "1",
    "description" => 'Load <code>project.js</code> on front-end',
  ],
  "uikit_lightbox" => [
    "type" => "radio",
    "label" =>  "UIkit Lightbox",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "0",
    "description" => 'Trigger uikit lightbox on all <code>.uikit-lightbox</code> elements based on <code>href</code> or <code>data-href</code> attributes',
  ],
  "ajax" => [
    "type" => "radio",
    "label" =>  "Ajax route",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "1",
    "description" => 'Enable /ajax/ route',
  ],
  "htmx" => [
    "type" => "radio",
    "label" =>  "HTMX integration",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "1",
    "description" => 'Load htmx on front-end, enable <code>./?htmx=</code> requests',
  ],
  "svg_folder" => [
    "type" => 'text',
    "label" => "SVG Folder",
    "placeholder" => "/assets/svg/",
    "description" => "SVG folder path used with <code>tpf_svg_dir()</code> and <code>tpf_svg_uri()</code>",
  ]
];

$developer_arr['Developer Options'] = $dev;


$smtp = [
  "smtp_enable" => [
    "type" => "radio",
    "label" =>  "Enable SMTP",
    "options" => ["1" => "Enabled", "0" => "Disabled"],
    "default" => "0",
  ],
  "smtp_from_email" => [
    "type" => "email",
    "label" =>  "From Email",
    "hidden" => the_project("smtp_enable") ? "1" : "0",
  ],
  "smtp_from_name" => [
    "type" => "text",
    "label" =>  "From Name",
    "hidden" => the_project("smtp_enable") ? "1" : "0",
  ],
  "smtp_host" => [
    "type" => "text",
    "label" =>  "Host",
    "hidden" => the_project("smtp_enable") ? "1" : "0",
  ],
  "smtp_port" => [
    "type" => "text",
    "label" =>  "Port",
    "hidden" => the_project("smtp_enable") ? "1" : "0",
  ],
  "smtp_secure" => [
    "type" => "radio",
    "label" =>  "Secure",
    "options" => [
      "tls" => "TLS",
      "ssl" => "SSL"
    ],
    "hidden" => the_project("smtp_enable") ? "1" : "0",
  ],
  "smtp_username" => [
    "type" => "text",
    "label" =>  "User Name",
    "hidden" => the_project("smtp_enable") ? "1" : "0",
  ],
  "smtp_password" => [
    "type" => "password",
    "label" =>  "Password",
    "hidden" => the_project("smtp_enable") ? "1" : "0",
  ],
];

$developer_arr['SMTP'] = $smtp;
