<?php

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