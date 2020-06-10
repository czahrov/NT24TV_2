<?php /* Template Name: test */ ?>
<?php //get_header(); ?>
<?php
  global $fp;
  // $main_menu = wp_get_nav_menu_items('glowne-menu');
  // print_r( $main_menu );
  // print_r( array_map( function($item){
  //   $ret = new stdClass();
  //   $ret->title = $item->title;
  //   $ret->url = $item->url;
  //   $ret->permalink = get_the_permalink( $item->ID );
  //   $ret->home = home_url();
  //
  //   return $ret;
  // }, $main_menu ) );
  // $category = get_category( 269 );
  // print_r( $category );
  // var_dump( get_category_link( 269 ) );
  var_dump( get_category_by_path( 'https://nowytarg24.tv/kategoria/portal/przeglad-tygodniowy/', false ) );
?>
<?php //get_footer(); ?>
