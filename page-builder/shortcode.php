<?php
$title = get_sub_field('title');
$shortcode = get_sub_field('shortcode');
$shortcode = str_replace('[', '', $shortcode);
$shortcode = str_replace(']', '', $shortcode);
$shortcode = "[$shortcode]";
?>

<?php if(!empty($title)) :?>
  <h2><?= $title ?></h2>
<?php endif;?>

<?php echo do_shortcode($shortcode); ?> 