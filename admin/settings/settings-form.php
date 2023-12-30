<?php

/**
 * The Project Settings
 */

if (!defined('ABSPATH')) {
  exit;
}


$dashicons = file_get_contents(plugin_dir_path(__FILE__) . "../lib/json/dashicons.json");
$dashicons = json_decode($dashicons, true);

if (isset($_POST["project_info_form_submit"])) {
  $json_file = get_template_directory() . "/the-project.json";
  $json_data = json_encode($_POST);
  file_put_contents($json_file, $json_data);
  wp_redirect('./options-general.php?page=project-settings');
}
?>
<div class="p-card p-padding p-margin">
  <h2 class="p-card-heading">Project</h2>
  <form action="./options-general.php?page=project-settings" class="p-form" method="POST">
    <table class="p-table p-table-sm p-table-striped">
      <tr>
        <th>Name</th>
        <td><input class="regular-text" type="text" name="name" value="<?= the_project('name') ?>" /></td>
      </tr>
      <tr>
        <th>Icon</th>
        <td>
          <select name="icon">
            <?php foreach ($dashicons as $key => $val) : ?>
              <option value="dashicons-<?= $key ?>" <?= the_project('icon') == "dashicons-$key" ? "selected" : "" ?>>
                <?= $key ?>
              </option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr>
        <th></th>
        <td>
          <input class="p-btn p-btn-sm" type="submit" name="project_info_form_submit" value="Save" />
        </td>
      </tr>
    </table>
  </form>
</div>

<div class="p-card p-padding p-margin">
  <form class="p-form" action="options.php" method="post">
    <?php
    settings_fields('project_settings');
    do_settings_sections('project-settings');
    ?>
    <table class="form-table" role="presentation">
      <tbody>
        <tr>
          <th>Test</th>
          <td>
            <input type="text" name="project_settings[test]" value="<?= the_project('test') ?>" />
          </td>
        </tr>
        <tr>
          <th scope="row"></th>
          <td>
            <input type="submit" name="submit" class="p-btn" value="<?php esc_attr_e('Save'); ?>" />
          </td>
        </tr>
      <tbody>
    </table>
  </form>
</div>