<?php
/**
 *  Render Picture
 *  @param object $image
 *  @example $source = ["max-width: 600px" => $image['sizes']['600'];
 */
function tpf_picture($image, $args = []) {

  if(empty($image)) return;

  $size = !empty($args['size']) ? $args['size'] : false;
  $alt = !empty($args['alt']) ? $args['alt'] : $image['alt'];
  $lazy = !empty($args["lazy"]) && $args["lazy"] == "false" ? false : true;
  $webp = !empty($args["webp"]) && $args["webp"] == "true" ? true : false;
  $class = !empty($args["class"]) ? $args["class"] : false;
  $img_class = !empty($args["img_class"]) ? $args["img_class"] : false;
  $img_attr = !empty($args["img_attr"]) ? $args["img_attr"] : false;
  $source = !empty($args["source"]) ? $args["source"] : [];

  if($size) {
    $size_width = "{$size}-width";
    $size_height = "{$size}-height";
    $width = !empty($args['width']) ? $args['width'] : $image['sizes'][$size_width];
    $height = !empty($args['height']) ? $args['height'] : $image['sizes'][$size_height];
  } else {
    $width = !empty($args['width']) ? $args['width'] : $image['width'];
    $height = !empty($args['height']) ? $args['height'] : $image['height'];
  }

  $img = $size ? $image['sizes']["$size"] : $image['url'];
  
  $attr = "";
  $cls = $class ? "class='$class'" : "";
  $img_cls = $img_class ? "class='$img_class'" : "";

  // lazy load or not
  $attr .= $lazy ? "loading='lazy'" : "";

  // img_attr
  $attr .= $img_attr ? " $img_attr" : "";

  // Start <picture> html
  $html = "<picture $cls>";

  // add additional sources if exists
  if(count($source)) {
    foreach($source as $media => $srcset) {
      $html .= "<source media='($media)' srcset='$srcset' />";
    }
  }

  if($webp) $html .= "<source srcset='($webp}' type='image/webp'>";

  $html .= "<img src='{$img}' alt='$alt' width='$width' height='$height' $img_cls $attr />";

  //end picture tag
  $html .= "</picture>";

  echo $html;
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