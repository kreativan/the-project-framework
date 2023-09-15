<?php
$site_settings = get_fields('options');

$post_type = get_post_type();
$permalink = get_permalink();

$seo_title = get_field('seo_title');
$seo_title = tpf_str_replace($seo_title, $site_settings);

$seo_desc = get_field('seo_description');
$seo_image = get_field('seo_image');
$favicon = get_field('favicon', 'options');

// dump($post_type);
// dump(is_singular());

//
//  Meta Tile Filter
//
add_filter( 'pre_get_document_title', function( $title ) {
  $site_settings = get_fields('options');
  $seo_title = get_field('seo_title');
  $seo_title = tpf_str_replace($seo_title, $site_settings);
  return !empty($seo_title) ? $seo_title : $title;
}, 999, 1 );

?>

<?php if(!empty($favicon)) : ?>
<link rel="icon" type="image/png" href="<?= $favicon['url'] ?>" />
<?php endif; ?>

<?php
  // Description
?>
<?php if(!empty($seo_desc)) :?>
<meta name="description" content="<?= $seo_desc ?>">
<?php endif; ?>

<?php
  //  Open Graph / Facebook 
?>
<meta property="og:type" content="website">
<meta property="og:url" content="<?= $permalink ?>">
<meta property="og:title" content="<?= !empty($seo_title) ? $seo_title : the_title() ?>">
<?php if(!empty($seo_desc)) :?>
<meta property="og:description" content="<?= $seo_desc ?>">
<?php endif; ?>
<?php if(!empty($seo_image)) :?>
  <meta property="og:image" content="<?= $seo_image['sizes']['large'] ?>">
<?php endif;?>

<?php 
  // Twitter 
?>
<?php if(!empty($seo_image)) :?>
  <meta property="twitter:card" content="<?= $seo_image['sizes']['large'] ?>">
<?php endif; ?>
<meta property="twitter:url" content="<?= $permalink ?>">
<meta property="twitter:title" content="<?= !empty($seo_title) ? $seo_title : the_title() ?>">

<?php
echo "\n";
?>

<?php
do_action("tpf_meta");
?>