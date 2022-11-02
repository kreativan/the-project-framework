<?php

class TPF {

  public function settings($field = "") {
    $arr = get_option('project_settings');
    if($field != "") {
      return isset($arr[$field]) ? $arr[$field] : "";
    } else {
      return $arr;
    }
  }

  public function site_settings($field) {
    if(function_exists("get_field")) {
      $value = get_field("$field", 'options');
      return !empty($value) ? $value : false;
    }
  }

  public function dir() {
    return WP_PLUGIN_DIR . "/the-project-framework/";
  }

  function url() {
    return plugin_dir_url(__DIR__);
  }

  /**  Check if current route is ajax */
  public function is_ajax_route() {
    $url = explode("/", $_SERVER['REQUEST_URI']);
    if($url[1] == 'ajax') return true;
    return false;
  }

  /**
   * Render (include) files 
   */
  function render($file_name, $args = []) {
    $plugin_dir = WP_PLUGIN_DIR . "/the-project-framework/";
    if(substr($file_name, -4) != ".php") $file_name = $file_name . ".php";
    $layout = $plugin_dir . $file_name;
    include($layout);
  }

  /**
   * Render ACF form
   */
  function form($id) {
    if (!$this->settings('forms')) {
      echo "<div class='uk-text-danger'>The Project forms are disabled</div>";
      return false;
    }
    $this->render("acf-forms/_form", ["id" => $id]);
  }

  //-------------------------------------------------------- 
  //  Menu
  //--------------------------------------------------------

  /**
   *  Get Menu items based on wp menu name
   *  @param string $name
   *  @return array; 
   */
  function get_menu($name) {
    $menu_items = wp_get_nav_menu_items($name);
    $array = [];
    foreach($menu_items as $item) {
      $item_arr = [
        'id' => $item->ID,
        'title' => $item->title,
        'href' => $item->url,  
        'object' => $item->object,
        'type' => $item->type,
      ];
      if($item->menu_item_parent) {
        $array[$item->menu_item_parent]["submenu"][] = $item_arr;
      } else {
        $array[$item->ID] = $item_arr;
      }
    }
    return $array;
  }


  //-------------------------------------------------------- 
  //  Media
  //-------------------------------------------------------- 

  /**
   * Image
   * @param object $image 
   * @param array $options
   */
  public function image($image, $options = []) {

    if(empty($image) || $image == "") return false;

    $size = isset($options['size']) ? $options['size'] : 'large';
    $class = isset($options['class']) ? $options['class'] : "";
    $eager = isset($options['eager']) && $options['eager'] == 1 ? true : false;

    $src = $image['sizes'][$size];
    $width = $image['sizes']["{$size}-width"];
    $height = $image['sizes']["{$size}-height"];
    $alt = $image['alt'] != '' ? $image['alt'] : $image['title'];

    $cls = "";
    $uk_img = "uk-img";

    if($eager) $uk_img = 'uk-img="loading: eager"';
    if($class != "") $cls = "class='$class'";

    echo "<img {$cls} data-src='{$src}' width='$width' height='$height' alt='{$alt}' {$uk_img} />";

  }

  /** Get SVG folder URl */
  public function svg_uri() {
    if(the_project("svg_folder")) {
      return get_template_directory_uri() . $this->settings('svg_folder');
    } else {
      return get_template_directory_uri() . "/assets/svg/";
    }
  }

  /** Get SVG folder path */
  public function svg_dir() {
    if($this->settings("svg_folder")) {
      return get_template_directory() . $this->settings('svg_folder');
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
  public function svg($svg_file, $options = []) {
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
  function youtube($url) {
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

  //-------------------------------------------------------- 
  //  HTMX
  //--------------------------------------------------------

  /** check if there is htmx req */
  function is_htmx_req() {
    if (isset($_GET['htmx']) && the_project('htmx')) return true;
  }

  /**
  * Htmx request attributes
  * @return string
  */
  public function htmx_req($file_path,  $config = [], $data = []) {

    $trigger = !empty($config["trigger"]) ? $config["trigger"] : "click";
    $target = !empty($config["target"]) ? $config["target"] : false;
    $swap = !empty($config["swap"]) ? $config["swap"] : false;
    $indicator = !empty($config["indicator"]) ? $config["indicator"] : false;
    $push_url = !empty($config["push_url"]) ? $config["push_url"] : false;
    $vals = count($data) > 0 ? $data : false;
    if($vals && is_array($vals)) $vals = json_encode($vals);

    $attr = "hx-get='./?htmx={$file_path}'";
    $attr .= " hx-trigger='$trigger'";
    if($target) $attr .= " hx-target='$target'";
    if($swap) $attr .= " hx-swap='$swap'";
    if($indicator) $attr .= " hx-indicator='$indicator'";
    if($push_url) $attr .= " hx-push-url='$push_url'";
    if($vals) $attr .= " hx-vals='$vals'";

    return $attr;

  }

  /**
   * HTMX modal req
   */
  public function htmx_modal($file_path, $data = []) {
    $attr = "hx-get='./?htmx={$file_path}'";
    $attr .= ' hx-target="body"';
    $attr .= ' hx-swap="beforeend"';
    $onclick = "tpf.htmxModal()";
    $attr .= " onclick=$onclick";
    if(count($data) > 0) {
      $vals = json_encode($data);
      $attr .= " hx-vals='$vals'";
    }
    return $attr;
  }

  /**
   * HTMX offcanvas req
   */
  public function htmx_offcanvas($file_path, $data = []) {
    $attr = "hx-get='./?htmx={$file_path}'";
    $attr .= ' hx-target="body"';
    $attr .= ' hx-swap="beforeend"';
    $onclick = "tpf.htmxOffcanvas()";
    $attr .= " onclick=$onclick";
    if(count($data) > 0) {
      $vals = json_encode($data);
      $attr .= " hx-vals='$vals'";
    }
    return $attr;
  }

}