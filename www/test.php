<?php /* Template Name: test */ ?>
<?php //get_header(); ?>
<?php
  error_reporting( E_ALL );
  global $fp;
  $date_now = date( 'Y-m-d H:i' );
  var_dump( $date_now );
  $category = get_category( 62 );
  var_dump( $category );
  $items = get_posts(array(
    'numberposts'   => 11,
    'cat'           => $category->cat_ID,
    'meta_query'     => array(
      'relation'  => 'AND',
      array(
        'key'     => 'event_start',
        'value'   => $date_now,
        'compare' => '<=',
      ),
      array(
        'key'     => 'event_end',
        'value'   => $date_now,
        'compare' => '>=',
      ),
    ),
  ));
  var_dump( $items );
?>
<?php //get_footer(); ?>
