<?php /* Template Name: test */ ?>
<?php //get_header(); ?>
<?php
  global $fp;
  echo "<!-- PINED_POST -->";
  $items_pined = get_posts(array(
    'numberposts'   => -1,
    'cat'           => 56,
    'orderby'       => 'date',
    'order'         => 'DESC',
    // 'meta_key'      => 'pin',
    // 'meta_value'    => '1',
    'meta_query' => array(
      array(
        'relation' => 'AND',
        array(
          'key'   => 'home',
          'value' => 1,
        ),
        array(
          'relation'  => 'AND',
          array(
            'key'   => 'pin',
            'value' => 1,
          ),
        )
      ),
    ),
  ));
  print_r( $items_pined );
  // print_r( get_post(108294) );
  // echo "<!-- POST_META -->";
  // print_r( get_post_meta(108294) );
?>
<?php //get_footer(); ?>
