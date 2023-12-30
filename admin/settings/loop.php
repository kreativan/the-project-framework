<?php

if (!defined('ABSPATH')) {
  exit;
}


$array = $args['array'];
$button = isset($args['button']) && $args['button'] ? true : false;
$margin = isset($args['margin']) && !$args['margin'] ? "" : "p-margin-top";
$i = 0;
?>

<?php foreach ($array as $key => $item) : ?>
  <div id="<?= str_replace(' ', '-', $key) ?>" class="tpf-settings-card p-margin <?= $key != 'Project' ? '' : '' ?> p-card p-padding<?= $i++ > 0 ? " $margin" : "" ?>">

    <h2><?= $key ?></h2>

    <table class="p-table p-table-striped">
      <tbody>

        <?php foreach ($item as $field_name => $field) : ?>

          <?php
          $default = isset($field['default']) ? $field['default'] : "";
          $value = the_project($field_name) != "" ? the_project($field_name) : $default;
          $placeholder = isset($field['placeholder']) ? $field['placeholder'] : "";
          ?>

          <tr style="<?= isset($field['hidden']) && !$field['hidden'] ? "display: none;" : "" ?>">

            <th style="width:320px;font-weight: normal;">
              <?= $field['label'] ?>
              <?php if (isset($field['description'])) : ?>
                <small style='display: block;color: #888'><?= $field['description'] ?></small>
              <?php endif; ?>
            </th>

            <td>

              <?php if ($field['type'] == "radio") : ?>

                <?php foreach ($field['options'] as $key => $label) : ?>
                  <label style="margin-right: 10px;">
                    <input type="radio" name="project_settings[<?= $field_name ?>]" value="<?= $key ?>" <?= ($value == $key) ? "checked" : "" ?> />
                    <?= $label ?>
                  </label>
                <?php endforeach; ?>

              <?php elseif ($field['type'] == "select") : ?>

                <select name="project_settings[<?= $field_name ?>]">
                  <option value="">- Select -</option>
                  <?php foreach ($field['options'] as $key => $label) : ?>
                    <option value="<?= $key ?>" <?= ($value == $key) ? "selected" : "" ?>>
                      <?= $label ?>
                    </option>
                  <?php endforeach; ?>
                </select>

              <?php elseif ($field['type'] == "text") : ?>

                <input type="text" name="project_settings[<?= $field_name ?>]" value="<?= $value ?>" placeholder="<?= $placeholder ?>" />

              <?php elseif ($field['type'] == "email") : ?>
                <input type="email" name="project_settings[<?= $field_name ?>]" value="<?= $value ?>" placeholder="<?= $placeholder ?>" />


              <?php elseif ($field['type'] == "password") : ?>
                <input type="password" name="project_settings[<?= $field_name ?>]" value="<?= $value ?>" placeholder="<?= $placeholder ?>" />


              <?php endif; ?>
            </td>

          </tr>
        <?php endforeach; ?>

      </tbody>
    </table>

    <?php if ($button) : ?>
      <div class="p-margin-top-sm">
        <button class="p-btn p-btn-xsm" type="submit" form="tpf-settings-form">
          Save
        </button>
      </div>
    <?php endif; ?>

  </div>
<?php endforeach; ?>