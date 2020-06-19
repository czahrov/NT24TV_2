<?php
  $category = get_category( 62 );
?>
<div id="nadchodzace" class="<?php echo getDevType(); ?> single-post sidebar-list padding-sm">
  <a href="<?php echo get_category_link( $category->cat_ID ); ?>">
    <h5 class="title-sidebar"><?php echo $category->name; ?></h5>
  </a>
  <ul class="image-sidebar-section padding no-padding-md">
    <?php
      $date_now = date( 'Y-m-d H:i' );
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
    ?>
    <!-- single post -->
    <?php
      foreach ($items as $item) {
        printPost( $item, 'side', array( 'img_size' => 'thumbnail' ) );
      }
    ?>

  </ul>
</div>
