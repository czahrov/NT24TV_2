<?php get_header(); ?>
<?php
  $devType = getDevType();
  the_post();
  $last_comments = get_comments(array(
    'post_id'   => get_the_ID(),
    'status'    => 'approve',
    'number'    => 1,
    'orderby'   => 'comment_date',
    'order'     => 'DESC',
  ));

  global $last_comment;
  $last_comment = $last_comments[0];
  $comments_num = get_comments(array(
    'post_id'   => get_the_ID(),
    'status'    => 'approve',
    'count'     => true,
  ));

  global $post_categories;
  $post_categories = wp_get_post_categories( get_the_ID(), array(
    'child_of' => get_category_by_slug('portal')->cat_ID,
  ));
?>
<!-- Page Content -->
<div id='post' class="<?php echo getDevType() . " " . get_category( $post_categories[0] )->slug; ?>">
  <?php
    // var_dump( $categories );
    if( in_array( get_category_by_slug('nekrologi')->cat_ID, $post_categories ) ){
      get_template_part( "template/single-nekrolog-desktop" );
    }
    elseif( get_field('timeline_items') ){
      get_template_part( "template/single-timeline-desktop" );
    }
    else{
      get_template_part( "template/single-basic-desktop" );
    }
  ?>
</div>
<!-- /.container -->

<?php get_footer(); ?>
