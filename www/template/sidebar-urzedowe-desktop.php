<div id="tasmy" class="<?php echo getDevType(); ?>">
  <?php
    $category = get_category( 76 );
  ?>
  <a href="<?php echo get_category_link( $category->cat_ID ); ?>">
    <h5 class="title-sidebar line"><?php echo $category->name; ?></h5>
  </a>
  <ul class="image-sidebar-section">
    <?php
      $items = get_posts(array(
        'numberposts'   => 6,
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
