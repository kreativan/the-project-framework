<?php
/**
 *  Custom Settings Form
 *  @author Ivan Milincic <kreativan.dev@gmail.com>
 *  @link http://kraetivan.dev
*/

$array_left = [];
$array_right = [];

//  Project
// ===========================================================

$dashicons = file_get_contents(plugin_dir_path(__FILE__)."../lib/json/dashicons.json");
$dashicons = json_decode($dashicons, true);
$dashicons_custom_array = [];
foreach($dashicons as $key => $value) $dashicons_custom_array[$key] = $key;

$project = [
  "name" => [
    "type" => "text",
    "label" =>  "Name",
    "default" => "The Project",
  ],
  "icon" => [
    "type" => "select",
    "label" =>  "Icon",
    "options" => $dashicons_custom_array,
    "default" => "superhero",
  ],
  "svg_folder" => [
    "type" => 'text',
    "label" => "SVG Folder",
    "placeholder" => "/assets/svg/",
  ]
];

//  Dev
// ===========================================================
$dev = [
  "dev_mode" => [
    "type" => "radio",
    "label" =>  "Dev Mode",
    "options" => [
      "1" => "Enabled",
      "0" => "Disabled"
    ],
    "default" => "1",
  ],
  "project_js" => [
    "type" => "radio",
    "label" =>  "Load project.js",
    "options" => [
      "1" => "Enabled",
      "0" => "Disabled"
    ],
    "default" => "1",
  ],
  "ajax" => [
    "type" => "radio",
    "label" =>  "Ajax route",
    "options" => [
      "1" => "Enabled",
      "0" => "Disabled"
    ],
    "default" => "1",
  ],
  "htmx" => [
    "type" => "radio",
    "label" =>  "HTMX integration",
    "options" => [
      "1" => "Enabled",
      "0" => "Disabled"
    ],
    "default" => "1",
  ],
  "assets_suffix" => [
    "type" => "text",
    "label" =>  "Assets Suffix",
    "hidden" => the_project("dev_mode") ? "0" : "1",
  ],
];

//  SMTP
// ===========================================================  

$smtp = [
  "smtp_enable" => [
    "type" => "radio",
    "label" =>  "Enable SMTP",
    "options" => [
      "1" => "Enabled",
      "0" => "Disabled"
    ],
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


//  Addons
// ===========================================================

$addons = [
  "forms" => [
    "type" => "radio",
    "label" =>  "Forms",
    "options" => [
      "1" => "Enabled",
      "0" => "Disabled"
    ],
    "default" => "1",
  ],
  "translations" => [
    "type" => "radio",
    "label" =>  "Translations",
    "options" => [
      "1" => "Enabled",
      "0" => "Disabled"
    ],
    "default" => "1",
  ],
  "user_groups" => [
    "type" => "radio",
    "label" =>  "User Groups",
    "options" => [
      "1" => "Enabled",
      "0" => "Disabled"
    ],
    "default" => "0",
  ],
  "discounts" => [
    "type" => "radio",
    "label" =>  "Discounts",
    "options" => [
      "1" => "Enabled",
      "0" => "Disabled"
    ],
    "hidden" => the_project("woo") ? "1" : "0",
    "default" => "0",
  ],
];

//  WooCommerce
// ===========================================================  

$woo = [
  "woo" => [
    "type" => "radio",
    "label" =>  "WooCommerce",
    "options" => [
      "1" => "Enabled",
      "0" => "Disabled"
    ],
    "default" => "0",
  ],
  "woo_scripts" => [
    "type" => "radio",
    "label" =>  "Load default scripts",
    "options" => [
      "1" => "Enabled",
      "0" => "Disabled"
    ],
    "hidden" => the_project("woo") ? "1" : "0",
    "default" => "1",
  ],
  "woo_styles" => [
    "type" => "radio",
    "label" =>  "Load default styles",
    "options" => [
      "1" => "Enabled",
      "0" => "Disabled"
    ],
    "hidden" => the_project("woo") ? "1" : "0",
    "default" => "0",
  ],
  "woo_js" => [
    "type" => "radio",
    "label" =>  "Load custom woo.js",
    "options" => [
      "1" => "Enabled",
      "0" => "Disabled"
    ],
    "hidden" => the_project("woo") ? "1" : "0",
    "default" => "1",
  ],
];

//  Final
// ===========================================================

$array_left['Project'] = $project;
$array_left['Developer Options'] = $dev;
$array_left['SMTP'] = $smtp;
$array_left['Add-ons'] = $addons;

if ( class_exists( 'WooCommerce' ) ) {
  $array_left['WooCommerce'] = $woo;
}

?>

<h1 class="p-margin">
  <span class="dashicons dashicons-admin-generic" style="font-size: 1em;margin-right:5px;position:relative;top:-3px"></span>
  The Project Framework
</h1>

<hr class="p-margin" />

<form id="tpf-settings-form" class="p-form p-margin-remove" action="options.php" method="post">

  <?php 
    settings_fields('project_settings');
    do_settings_sections('project-settings');
  ?>

  <div class="p-grid p-grid-1 p-grid-gap">

    <?php if(count($array_left) > 0) :?>
    <div class="left">
      <?php
        tpf_render("settings/loop.php", [
          "array" => $array_left,
        ])
      ?>
    </div>
    <?php endif; ?>

    <?php if(count($array_right) > 0) :?>
    <div class="right">
      <?php
        tpf_render("settings/loop.php", [
          "array" => $array_right,
        ])
      ?>
    </div>
    <?php endif; ?>

  </div>

  <div class="p-margin-top">
    <input
    type="submit"
      name="submit"
      class="p-btn"
      value="<?php esc_attr_e( 'Save Settings' ); ?>"
    />
  </div>

</form>