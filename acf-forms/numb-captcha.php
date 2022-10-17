<?php namespace ProcssWire; 
/**
 *  Numb. Captcha Markup
 *  @author Ivan Milincic <kreativan.dev@gmail.com>
 *  @link http://kraetivan.dev
*/


$q1 = rand(1, 10);
$q2 = rand(1, 10);

$args = isset($args) ? $args : false;

if(is_project_htmx()) {
  $args = isset($_REQUEST) ? $_REQUEST : $args;
}

$label = isset($args['label']) && ($args['label'] == 1 || $args['label'] == 'true') ? true : false; 

$placeholder = $label ? "?" : "$q1+$q2 = ?";
$input_size =  $label ? "80px" : "120px";

?>

<div class="uk-grid uk-grid-small uk-flex-middle">

  <?php if($label) :?>
  <div class="uk-width-auto uk-h4"><?= $q1 ?>+<?= $q2 ?> = </div>
  <?php endif;?>

  <div class="uk-width-auto" style="width: <?= $input_size ?>;">
    <input type="hidden" name="numb_captcha_q1" value="<?= $q1 ?>">
    <input type="hidden" name="numb_captcha_q2" value="<?= $q2 ?>">
    <!---
    <input type="hidden" name="numb_captcha" value="<?= $q1 + $q2 ?>">
    -->
    <input 
      class="uk-input uk-text-center" 
      type="text" 
      name="numb_captcha_answ" 
      placeholder="<?= $placeholder ?>" 
      required 
    />
  </div>

</div>