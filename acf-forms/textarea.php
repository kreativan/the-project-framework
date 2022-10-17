<?php namespace ProcessWire;
/**
 *  Textarea Markup
 *  @author Ivan Milincic <kreativan.dev@gmail.com>
 *  @link http://kraetivan.dev
 *
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
$rows = isset($args['rows']) ? $args['rows'] : false; 

?>

<?php if($label) : ?>
<label class="uk-form-label" for="input-<?= $name ?>">
  <?= $label ?>
  <?php if($required) : ?>
    <span class="uk-text-danger">*</span>
  <?php endif;?>
</label>
<?php endif;?>

<textarea 
  class="uk-textarea" 
  id="input-<?= $name ?>"
  name="<?= $name ?>"
  placeholder="<?= $placeholder ?>"
  <?php if($required) echo 'required'; ?>
  <?php if($rows) echo "rows='$rows'"; ?>
><?= $value ?></textarea>