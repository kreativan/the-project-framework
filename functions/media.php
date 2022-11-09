<?php

/**
 * Image
 * @param object $image 
 * @param array $options
 */

function tpf_image($image, $options = []) {

  if(empty($image) || $image == "") return false;

  $size = isset($options['size']) ? $options['size'] : 'large';
  $class = isset($options['class']) ? $options['class'] : "";
  $eager = isset($options['eager']) && $options['eager'] == 1 ? true : false;

  $svg_width = isset($options['width']) ? $options['width'] : '';
  $svg_height = isset($options['height']) ? $options['height'] : '';

  $src = $image['sizes'][$size];
  $width = $image['sizes']["{$size}-width"];
  $height = $image['sizes']["{$size}-height"];
  $alt = $image['alt'] != '' ? $image['alt'] : $image['title'];

  $cls = "";
  $uk_img = "uk-img";

  if($eager) $uk_img = 'uk-img="loading: eager"';
  if($class != "") $cls = "class='$class'";

  if($image['subtype'] == "svg+xml") {
    echo "<img {$cls} data-src='{$src}' width='$svg_width' height='$svg_height' alt='{$alt}' uk-svg />";
  } else {
    echo "<img {$cls} data-src='{$src}' width='$width' height='$height' alt='{$alt}' {$uk_img} />"; 
  }

}

/**
 * SVG
 *
 */

function tpf_svg_uri() {
  if(the_project("svg_folder")) {
    return get_template_directory_uri() . the_project('svg_folder');
  } else {
    return get_template_directory_uri() . "/assets/svg/";
  }
}

function tpf_svg_dir() {
  if(the_project("svg_folder")) {
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
  $svg_file = get_template_directory() . "{$svg_file}.svg";
  if(!file_exists($svg_file)) return false;

  // Options
  $type = !empty($options["type"]) ? $options["type"] : "stroke"; // stroke / fill
  $color = !empty($options["color"]) ? $options["color"] : ""; // hex
  $size = !empty($options["size"]) ? $options["size"] : "28px"; // px
  $class = "svg-$type";
  $class .= !empty($options["class"]) ? " " . $options["class"] : "";
  $sty = !empty($options["style"]) ? $options["style"] : ""; // style=""

  $style = "width:$size;height:$size;";
  if($color != "") {
    $style .= ($type == "stroke") ? "stroke: $color;" : "fill: $color;";
  }
  $style .= !empty($sty) ? " $sty" : "";

  $svg = file_get_contents($svg_file);
  echo "<span class='svg {$class}' style='{$style}'>{$svg}</span>";
}


/**
 *  Get Youtube embed url from regular url
 *  @param $url - regular youtube url
 */
function tpf_youtube($url) {
  $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
  $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';
  if (preg_match($longUrlRegex, $url, $matches)) {
    $youtube_id = $matches[count($matches) - 1];
  }
  if (preg_match($shortUrlRegex, $url, $matches)) {
    $youtube_id = $matches[count($matches) - 1];
  }
  return 'https://www.youtube.com/embed/' . $youtube_id ;
}