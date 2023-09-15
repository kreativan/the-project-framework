<?php

if (has_nav_menu('navbar')) {
  wp_nav_menu([
    'theme_location' => 'navbar',
    'menu_class' => 'uk-navbar-nav',
    'walker' => new Walker_Navbar(),
  ]);
}
