<?php

/**
 *  Less Compiler Class
 *  @author Ivan Milincic <kreativan.dev@gmail.com>
 *  @link http://kraetivan.dev
 *
 *  @example 
 *  $lessCompiler = new LessCompiler;
 *  $lessCompiler->less($less_files, $less_vars, "main", $dev_mode);
 *
 */

class Less_Compiler {

  public function __construct($output_dir = "assets") {

    $this->assets_folder = get_template_directory() . "/$output_dir/";
    $this->assets_url = get_template_directory_uri() . "/$output_dir/";

    $this->cache_path = WP_CONTENT_DIR . "/less-cache/";
    $this->cache_url = content_url() . "/less-cache/";
    $dir = WP_CONTENT_DIR . "/cache/";
  }

  /**
   *  Main Less Compiler Function
   *  @param array $less_files - less file paths
   *  @param array $variables - eg: ['@basic-font-family' => "Ariel"]
   *  @param string $output_file - output file name
   *  @param bool $cache - return cache url or compiled file url
   *  @return string
   */
  public function less($less_files, $variables = [], $output_file = "main", $cache = true) {
    $css_file_path = $this->assets_folder . "css/{$output_file}.css";
    if ($cache || !file_exists($css_file_path)) {
      return $this->compile($less_files, $variables, $output_file);
    } else {
      return $this->assets_url . "css/{$output_file}.css";
    }
  }

  // compile less and return cache url
  public function compile($less_files, $variables = [], $file_name = "main") {

    wp_mkdir_p($this->cache_path);

    // load less.php if it is not already loaded
    // a simple require_once does not work properly
    require_once(__DIR__ . "/../../lib/less.php/lib/Less/Autoloader.php");
    Less_Autoloader::register();

    $output_file_name = "{$file_name}.css";
    $css_file_path = $this->assets_folder . "css/{$output_file_name}";

    $root_url = get_site_url();
    $cache_folder = $this->cache_path;
    $cache_url = $this->cache_url;

    $less_array = [];
    foreach ($less_files as $file) $less_array[$file] = $root_url;

    $options = [
      'cache_dir' => $cache_folder,
      'compress' => true,
    ];

    try {
      $css_file_name = Less_Cache::Get($less_array, $options, $variables);
      $compiled = file_get_contents($cache_folder . $css_file_name);
      file_put_contents($css_file_path, $compiled);
    } catch (Exception $e) {
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

    return $cache_url . $css_file_name;
  }
}
