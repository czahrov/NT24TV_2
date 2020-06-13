<?php /* Template Name: test */ ?>
<?php //get_header(); ?>
<?php
  global $fp;
  $post_id = 113411;
  // $timeNow = date_create()->getTimestamp();
  $timePost_1 = date_create( get_the_date( 'Y-m-d H:i:s', $post_id ) )->getTimestamp();
  $timePost_2 = get_post_datetime( $post_id )->getTimestamp();
  var_dump( $timePost_1 );
  var_dump( $timePost_2 );
  var_dump( $timePost_1 - $timePost_2 );
?>
<?php //get_footer(); ?>
