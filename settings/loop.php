<?php
$array = $args['array'];
$button = isset($args['button']) && $args['button'] == 'true' ? true : false;
$i = 0;
?>

<?php foreach($array as $key => $item) : ?>
<div class="p-card p-padding<?= $i++ > 0 ? " p-margin-top" : "" ?>">

  <h2><?= $key ?></h2>

  <table class="p-table p-table-striped">
    <tbody>

      <?php foreach($item as $field_name => $field) : ?>
      <tr style="<?= isset($field['hidden']) && !$field['hidden'] ? "display: none;" : "" ?>">

        <th style="width:200px;font-weight: normal;"><?= $field['label'] ?></th>

        <td>

          <?php if($field['type'] == "radio") : ?>

          <?php foreach($field['options'] as $key => $value) :?>
          <label style="margin-right: 10px;">
            <input type="radio" name="project_settings[<?= $field_name ?>]" value="<?= $key ?>"
              <?= the_project($field_name) == $key ? "checked" : "" ?> />
            <?= $value ?>
          </label>
          <?php endforeach; ?>

          <?php elseif($field['type'] == "select") : ?>

          <select name="project_settings[<?= $field_name ?>]">
            <?php foreach($field['options'] as $key => $value) :?>
            <option value="<?= $key ?>" <?= the_project($field_name) == $key ? "selected" : "" ?>>
              <?= $value ?>
            </option>
            <?php endforeach; ?>
          </select>

          <?php elseif($field['type'] == "text") : ?>

          <input type="text" name="project_settings[<?= $field_name ?>]" value="<?= the_project($field_name) ?>" />

          <?php elseif($field['type'] == "email") : ?>
          <input type="email" name="project_settings[<?= $field_name ?>]" value="<?= the_project($field_name) ?>" />


          <?php elseif($field['type'] == "password") : ?>
          <input type="password" name="project_settings[<?= $field_name ?>]" value="<?= the_project($field_name) ?>" />


          <?php endif;?>
        </td>

      </tr>
      <?php endforeach;?>

    </tbody>
  </table>

  <?php if($button) : ?>
  <div class="p-margin-top">
    <button class="p-btn p-btn-sm" type="submit" form="tpf-settings-form">Save</button>
  </div>
  <?php endif;?>

</div>
<?php endforeach; ?>
