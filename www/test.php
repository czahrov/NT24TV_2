<?php /* Template Name: test */ ?>
<?php get_header(); ?>
<?php
  global $fp;
  // $fp->embed_video_for_post( 108188 );
  // $fp->embed_video_for_post( 108463 );
  // var_dump( get_category_by_slug('koronawirus')->term_id );
  // var_dump( get_category_by_slug('koronawirus')->cat_ID );
  // var_dump( get_field( 'front', get_category_by_slug('koronawirus')->term_id ) );
  $catSlug = 'koronawirus';
  var_dump( get_term_meta( get_category_by_slug( $catSlug )->cat_ID, 'front', true ) );
?>
<?php get_footer(); ?>
