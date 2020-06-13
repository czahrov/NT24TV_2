<?php
  $category = get_category( 62 );
?>
<div id="nadchodzace" class="<?php echo getDevType(); ?> single-post sidebar-list padding-sm">
  <a href="<?php echo get_category_link( $category->cat_ID ); ?>">
    <h5 class="title-sidebar"><?php echo $category->name; ?></h5>
  </a>
  <ul class="image-sidebar-section padding no-padding-md">
    <?php
      $items = get_posts(array(
        'numberposts'   => 11,
        'cat'           => $category->cat_ID,
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
