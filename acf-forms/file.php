<?php namespace ProcssWire; 
/**
 *  File Input Markup
 *  @author Ivan Milincic <kreativan.dev@gmail.com>
 *  @link http://kraetivan.dev
*/

$args = isset($args) ? $args : false;

if(is_project_htmx()) {
  $args = isset($_REQUEST) ? $_REQUEST : $args;
}

$label = isset($args['label']) ? $args['label'] : false; 
$name = isset($args['name']) ? $args['name'] : ""; 
$placeholder = isset($args['placeholder']) ? $args['placeholder'] : "";
$required = isset($args['required']) && ($args['required'] == 1 || $args['required'] == 'true') ? true : false;

?>

<?php if($label) : ?>
<label class="uk-form-label" for="input-<?= $name ?>">
  <?= $label ?>
  <?php if($required) : ?>
    <span class="uk-text-danger">*</span>
  <?php endif;?>
</label>
<?php endif;?>

<div uk-form-custom="target: true">
  <input
    id="input-<?= $name ?>" 
    type="file" 
    name="<?= $name ?>"
  >
  <input class="uk-input" type="text" placeholder="<?= $placeholder ?>" disabled>
</div>