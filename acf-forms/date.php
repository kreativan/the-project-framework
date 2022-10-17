<?php namespace ProcssWire; 
/**
 *  Date Markup
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

?>

<?php if($label) : ?>
<label class="uk-form-label" for="input-<?= $name ?>">
  <?= $label ?>
  <?php if($required) : ?>
    <span class="uk-text-danger">*</span>
  <?php endif;?>
</label>
<?php endif;?>

<input 
  class="uk-input"
  id="input-<?= $name ?>"
  type="date"
  name="<?= $name ?>"
  value="<?= $value ?>"
  <?php if($required) echo 'required'; ?>
/>