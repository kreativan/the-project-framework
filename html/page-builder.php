<?php

/**
 *  Page Builder
 *  @example get_template_part('layout/base/page-builder', null, $args); 
 *  @param string $container_class
 *  @param string $folder - folder path from where to include blocks
 *  @param array $layout_settings
 *  
 
    $args = [ 
      'folder' => 'page-builder/', // blocks layout folder
      'container_class' => "uk-container uk-container-small",
      'space' => 'medium', // default space
      'split_section' => [
        'style' => 'primary', // primary, secondary, default
        'space' => 'no-space', // no-space, default, medium, large, small
        'class' => 'my-custom-class',
      ],
    ]

 *
 */

$post_id = isset($args['post_id']) ? $args['post_id'] : null;
$page_builder = get_field('page_builder', $post_id);

$folder = !empty($args['folder']) ? $args['folder'] : "page-builder/";
$container_class = !empty($args['container_class']) ? $args['container_class'] : "";

$default_space = !empty($args['space']) ? $args['space'] : "normal";

$i = 1;
?>

<?php while (have_rows("page_builder")) :
  the_row();
  $layout = get_row_layout();
  $enabled = get_sub_field('enable');
  if ($enabled) {
?>

    <?php

    $n = $i++;

    $pb_style = !empty(get_sub_field('pb_style')) ? get_sub_field('pb_style') : 'default';
    $pb_space = !empty(get_sub_field('pb_space')) ? get_sub_field('pb_space') : $default_space;

    $layout_settings = isset($args[$layout]) ? $args[$layout] : false;

    if ($layout_settings) {
      if (isset($layout_settings['style'])) $pb_style = $layout_settings['style'];
      if (isset($layout_settings['space'])) $pb_space = $layout_settings['space'];
    }

    $class = "block $layout style-$pb_style space-$pb_space";

    // If there is layout specific class add it
    if ($layout_settings && isset($layout_settings['class'])) {
      $class .= " {$layout_settings['class']}";
    }

    if ($pb_space != 'no-space') {
      $class .= $pb_style != 'default' ? " uk-section uk-section-$pb_space uk-section-$pb_style" : " uk-margin-$pb_space uk-section-$pb_style";
    } else {
      $class .= " no-space";
    }

    if ($n == 1) $class .= " block-first";
    if ($n == count($page_builder)) $class .= " block-last";

    ?>

    <div class="<?= $class ?>">

      <?php if ($pb_space != "no-space" && $container_class != "") : ?>
        <div class="<?= $container_class ?>">
        <?php endif; ?>

        <?php
        render("{$folder}{$layout}");
        wp_reset_postdata();
        ?>

        <?php if ($pb_space != "no-space" && $container_class != "") : ?>
        </div>
      <?php endif; ?>

    </div>

  <?php } ?>
<?php endwhile; ?>