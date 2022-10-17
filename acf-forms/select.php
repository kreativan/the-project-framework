<?php namespace ProcssWire; 
/**
 *  Select Markup
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
$placeholder = isset($args['placeholder']) ? $args['placeholder'] : ""; 
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

<select 
  class="uk-select" 
  id="input-<?= $name ?>"
  name="<?= $name ?>"
  <?php if($required) echo 'required'; ?>
>
  <option value="">- <?= $placeholder ?> -</option>
  <?php if($field_options) : ?>
  <?php foreach($field_options as $key => $label) : ?>
    <option value="<?= $key ?>" <?php if ($key == $value) echo "selected"; ?>>
      <?= $label ?>
    </option>
  <?php endforeach; ?>
  <?php endif;?>
</select>