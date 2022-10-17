<?php namespace ProcssWire; 
/**
 *  Checkbox Markup
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
$placeholder = isset($args['placeholder']) ? $args['placeholder'] : ""; 
$is_checked = isset($args['is_checked']) && $args['is_checked'] == 1 ? true : false; 

?>

<?php if($label) : ?>
<label class="uk-form-label" for="input-<?= $name ?>">
  <?= $label ?>
  <?php if($required) : ?>
    <span class="uk-text-danger">*</span>
  <?php endif;?>
</label>
<?php endif;?>

<label>
  <input 
    class="uk-checkbox"
    type="checkbox" 
    id="input-<?= $name ?>"
    name="<?= $name ?>"
    value="<?= $value ?>"
    <?php if($required) echo 'required'; ?>
    <?php if($is_checked) echo 'checked'; ?>
  />
  <span><?= $placeholder ?></span>
</label>