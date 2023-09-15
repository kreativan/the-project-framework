<?php

namespace TPF;

class SEO {

  public function __construct() {
    if (function_exists('acf_add_local_field_group')) {
      if (the_project('seo') == "1") {
        tpf_acf_group_init('seo');
      }
    }
  }
}
