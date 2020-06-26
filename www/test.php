<?php /* Template Name: test */ ?>
<?php //get_header(); ?>
<?php
  global $fp;
  $post_id = 111689;
  $posts_limit = 12;

  $post_categories = wp_get_post_categories( $post_id, array(
    'child_of' => 68,
  ) );
  echo "POST_CATEGORIES" . PHP_EOL;
  print_r( $post_categories );

  $post_tags = wp_get_post_tags( $post_id );
  echo "POST_TAGS" . PHP_EOL;
  print_r( $post_tags );
  $post_tags_list = array_map( function($tag){
    return $tag->term_id;
  }, $post_tags );

  $similar_posts = get_posts(array(
    'numberposts'=>$posts_limit,
    'category__in'=>$post_categories,
    'tag__in'=>$post_tags_list,
  ));
  echo "SIMILAR_POSTS" . PHP_EOL;
  print_r( $similar_posts );
?>
<?php //get_footer(); ?>
