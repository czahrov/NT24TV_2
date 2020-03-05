<?php
  add_theme_support('post-formats', array( 'gallery', 'video' ));
  add_theme_support('post-thumbnails');
  register_nav_menus(array(
    'main' => 'Menu główne, wyświetlane na górze strony',
  ));

?>
