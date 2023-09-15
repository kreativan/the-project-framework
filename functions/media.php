<?php

/**
 * Image
 * @param object $image 
 * @param array $options
 */

function tpf_image($image, $options = []) {

  if (empty($image) || $image == "") return false;

  // options
  $size = isset($options['size']) ? $options['size'] : 'large';
  $class = isset($options['class']) ? $options['class'] : "";
  $eager = isset($options['eager']) && $options['eager'] == 1 ? true : false;

  $cls = "";
  $uk_img = "uk-img";

  $src = $image['sizes'][$size];
  $width = $image['sizes']["{$size}-width"];
  $height = $image['sizes']["{$size}-height"];
  $alt = $image['alt'] != '' ? $image['alt'] : $image['title'];

  if ($eager) $uk_img = 'uk-img="loading: eager"';
  if ($class != "") $cls = "class='$class'";

  echo "<img {$cls} data-src='{$src}' width='$width' height='$height' alt='{$alt}' {$uk_img} />";
}


/**
 * Image SVG uk-svg
 * @param object $image 
 * @param array $options
 */

function tpf_image_svg($image, $options = []) {

  if (empty($image) || $image == "") return false;

  $type = isset($options['type']) ? $options['type'] : 'stroke';
  $color = isset($options['color']) ? $options['color'] : 'currentColor';
  $stroke_width = isset($options['stroke_width']) ? $options['stroke_width'] : 1.5;
  $size = isset($options['size']) ? $options['size'] : 60;

  $class = "svg-image";
  $style = "";

  $class .= " svg-$type";
  $style = $type == 'stroke' ? "stroke: $color;" : "fill: $color;";
  $style .= "stroke-width: $stroke_width;";

  if ($style != "") $style = "style='$style'";

  $src = is_object($image) ? $image['url'] : $image;
  $alt = is_object($image) && $image['alt'] != '' ? $image['alt'] : '';

  echo "<img class='{$class}' data-src='{$src}' width='$size' height='$size' alt='{$alt}' uk-svg $style />";
}

/**
 * SVG
 *
 */

function tpf_svg_uri() {
  if (the_project("svg_folder")) {
    return get_template_directory_uri() . the_project('svg_folder');
  } else {
    return get_template_directory_uri() . "/assets/svg/";
  }
}

function tpf_svg_dir() {
  if (the_project("svg_folder")) {
    return get_template_directory() . the_project('svg_folder');
  } else {
    return get_template_directory() . "/assets/svg/";
  }
}

/**
 *  Render SVG
 *  @param string $svg_file - svg file path relative to the theme folder
 *  @param array $options
 *  @return markup
 */
function tpf_svg($svg_file, $options = []) {

  $folder = isset($options['folder']) ? $options['folder'] : tpf_svg_dir();
  $svg_file = str_replace('.svg', '', $svg_file);
  $svg_file = $folder . $svg_file . ".svg";
  if (!file_exists($svg_file)) return false;

  // Options
  $type = !empty($options["type"]) ? $options["type"] : "stroke"; // stroke / fill
  $color = !empty($options["color"]) ? $options["color"] : "currentcolor"; // hex
  $size = !empty($options["size"]) ? $options["size"] : "1em"; // px
  $class = "svg-$type";
  $class .= !empty($options["class"]) ? " " . $options["class"] : "";
  $sty = !empty($options["style"]) ? $options["style"] : ""; // style=""

  $style = "width:$size;height:$size;line-height:0.5;";
  if ($color != "") {
    $style .= ($type == "stroke") ? "stroke: $color;" : "fill: $color;";
  }
  $style .= !empty($sty) ? " $sty" : "";

  $svg = file_get_contents($svg_file);
  return "<span class='svg {$class}' style='{$style}'>{$svg}</span>";
}
