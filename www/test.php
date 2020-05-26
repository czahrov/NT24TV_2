<?php /* Template Name: test */ ?>
<?php get_header(); ?>
<?php
  global $fp;
  var_dump( get_page_by_title('Home') );
  var_dump( get_post(40) );
  var_dump( get_field( 'prezentacja', get_post( 40 )->ID ) );
?>
<?php get_footer(); ?>
