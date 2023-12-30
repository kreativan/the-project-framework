<?php

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class SEO {

  public function __construct() {
    if (function_exists('acf_add_local_field_group')) {
      if (the_project('seo') == "1") {
        TPF_ACF_Group_Init('seo');
      }
    }
  }
}
