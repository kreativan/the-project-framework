<?php
$page = get_queried_object();
$page_id = function_exists("is_shop") && is_shop() ? wc_get_page_id('shop') : get_the_ID();

$site_settings = site_settings();

$post_type = get_post_type();
$permalink = get_permalink();

$seo_title = get_field('seo_title', $page_id);
$seo_title = TPF_STR_Replace($seo_title, $site_settings);

$seo_desc = get_field('seo_description', $page_id);
$seo_desc = TPF_STR_Replace($seo_desc, $site_settings);
$seo_image = get_field('seo_image');
$favicon = get_field('favicon', 'options');

//
//  Meta title filter
//
add_filter('pre_get_document_title', function ($title) {
  $page_id = function_exists("is_shop") && is_shop() ? wc_get_page_id('shop') : get_the_ID();
  $site_settings = site_settings();
  $seo_title = get_field('seo_title', $page_id);
  $seo_title = TPF_STR_Replace($seo_title, $site_settings);
  return !empty($seo_title) ? $seo_title : $title;
}, 999, 1);

/**
 * Post
 */
if (is_singular('post')) {
  $seo_title = get_the_title();
  $seo_desc = get_the_excerpt();
  $seo_image = get_the_post_thumbnail_url();
}

/**
 * WooCommerce Products
 */
if (function_exists("is_product") && is_product()) {
  $seo_title = get_the_title();
  $seo_desc = get_the_excerpt();
  $seo_image = get_the_post_thumbnail_url();
}

/**
 * WooCommerce Product Categories
 */
if (function_exists('is_product_category') && is_product_category()) {
  $seo_title = $page->name;
  $seo_desc = $page->description;
  $thumbnail_id = get_term_meta($page->term_id, 'thumbnail_id', true);
  if ($thumbnail_id) {
    $seo_image = wp_get_attachment_url($thumbnail_id);
  }
}

?>

<?php if (!empty($favicon)) : ?>
<link rel="icon"
  type="image/png"
  href="<?= $favicon['url'] ?>" />
<?php endif; ?>

<?php
// Description
?>
<?php if (!empty($seo_desc)) : ?>
<meta name="description"
  content="<?= $seo_desc ?>">
<?php endif; ?>

<?php
//  Open Graph / Facebook 
?>
<meta property="og:type"
  content="website">
<meta property="og:url"
  content="<?= $permalink ?>">
<meta property="og:title"
  content="<?= !empty($seo_title) ? $seo_title : the_title() ?>">
<?php if (!empty($seo_desc)) : ?>
<meta property="og:description"
  content="<?= $seo_desc ?>">
<?php endif; ?>
<?php if (!empty($seo_image)) : ?>
<?php if (is_string($seo_image)) : ?>
<meta property="og:image"
  content="<?= $seo_image ?>">
<?php else : ?>
<meta property="og:image"
  content="<?= $seo_image['sizes']['large'] ?>">
<?php endif; ?>
<?php endif; ?>

<?php
// Twitter 
?>
<?php if (!empty($seo_image)) : ?>
<?php if (is_string($seo_image)) : ?>
<meta property="twitter:image"
  content="<?= $seo_image ?>">
<?php else : ?>
<meta property="twitter:card"
  content="<?= $seo_image['sizes']['large'] ?>">
<?php endif; ?>
<?php endif; ?>
<meta property="twitter:url"
  content="<?= $permalink ?>">
<meta property="twitter:title"
  content="<?= !empty($seo_title) ? $seo_title : the_title() ?>">

<?php
echo "\n";
?>

<?php
do_action("tpf_meta");
?>