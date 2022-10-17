<?php namespace ProcssWire; 
/**
 *  Checkboxes Markup
 *  @author Ivan Milincic <kreativan.dev@gmail.com>
 *  @link http://kraetivan.dev
*/

$args = isset($args) ? $args : false;

if(is_project_htmx()) {
  $args = isset($_REQUEST) ? $_REQUEST : $args;
}

$label = isset($args['label']) ? $args['label'] : false; 
$name = isset($args['name']) ? $args['name'] : ""; 
$value = isset($args['value']) ? $args['value'] : ""; 
$required = isset($args['required']) && ($args['required'] == 1 || $args['required'] == 'true') ? true : false; 
$field_options = isset($args['field_options']) ? $args['field_options'] : false;

?>

<?php if($label) : ?>
<label class="uk-form-label" for="input-<?= $name ?>">
  <?= $label ?>
  <?php if($required) : ?>
    <span class="uk-text-danger">*</span>
  <?php endif;?>
</label>
<?php endif;?>

<?php if($field_options) : ?>
<?php foreach($field_options as $key => $label) : ?>
<label>
  <input 
    class="uk-checkbox"
    type="checkbox" 
    id="input-<?= $name ?>"
    name="<?= $name ?>[]"
    value="<?= $key ?>"
    <?php if(is_array($value) && in_array($key, $value)) echo "checked"; ?>
  />
  <span><?= $label ?></span>
</label>
<?php endforeach; ?>
<?php endif;?>