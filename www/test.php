<?php /* Template Name: test */ ?>
<?php //get_header(); ?>
<?php
  global $fp;
  $id = 115017;
  // print_r( get_post( $id ) );
  // print_r( get_post_meta( $id ) );
  // print_r( get_post_meta( $id, '_wp_attachment_metadata' )[0] );
  print_r( get_field( 'obraz', 115016 ) );
?>
<?php //get_footer(); ?>
