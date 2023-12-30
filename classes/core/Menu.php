<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Custom TPF Menu Class
 */
class TPF_Menu {

  public function __construct() {
    add_filter('nav_menu_link_attributes', [$this, 'add_menu_link_attribute'], 10, 3);
  }

  public function add_menu_link_attribute($atts, $item, $args) {
    $new_tab = get_field('new_tab', $item);
    $nofollow = get_field('nofollow', $item);
    $htmx_modal = get_field('htmx_modal', $item);
    $htmx_link = get_field('htmx_link', $item);
    if ($new_tab) $atts['target'] = '_blank';
    if ($nofollow) $atts['rel'] = 'nofollow noopener noreferrer';
    if ($htmx_modal) {
      $atts['hx-get'] = "./?htmx=$htmx_link";
      $atts['hx-target'] = 'body';
      $atts['hx-swap'] = 'beforeend';
      $atts['hx-indicator'] = '#htmx-page-indicator';
      $atts['onclick'] = 'project.htmxModal()';
    }
    return $atts;
  }
}


// Navbar dropdown html/css update
class Walker_Navbar extends Walker_Nav_Menu {
  function start_lvl(&$output, $depth = 0, $args = null) {
    $indent = str_repeat("\t", $depth);
    $output .= "<div class='uk-navbar-dropdown'>";
    $output .= "\n$indent<ul class=\"uk-nav uk-navbar-dropdown-nav\">\n";
  }
}

// Navbar dropdown html/css update
class Walker_MobileMenu extends Walker_Nav_Menu {

  function start_lvl(&$output, $depth = 0, $args = null) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"uk-nav-sub\">\n";
  }
}
