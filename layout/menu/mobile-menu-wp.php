<?php
// menu position
$menu = !empty($menu) ? $menu : 'mobile-menu';

if (has_nav_menu($menu)) {
  wp_nav_menu([
    'theme_location' => $menu,
    'menu_class' => 'uk-nav uk-nav-primary',
    'walker' => new Walker_MobileMenu(),
  ]);
}
