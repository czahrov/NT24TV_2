<div class="reportaze">
  <?php $category = get_category( 61 ); ?>
  <a href="<?php echo get_category_link( $category->cat_ID ); ?>">
    <h5 class="title-sidebar line"><?php echo $category->name; ?></h5>
  </a>
  <?php
  $items = get_posts(array(
    'numberposts'     => 15,
    'cat'             => $category->cat_ID,
  ));
  ?>
  <ul class="image-sidebar-section alt">

    <!-- single post -->
    <?php
    foreach ( $items as $item ) {
      printPost( $item, 'side' );
    }
    ?>

  </ul>

</div>
