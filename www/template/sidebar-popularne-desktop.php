<div  id="sidebar-popularne" class="<?php echo getDevType(); ?> single-post sidebar-list padding">
  <h5 class="title-sidebar line">Najbardziej popularne</h5>
  <ul class="image-sidebar-section">
    <?php
      $category = get_category( 112 );
      $posts_limit = 8;
      $items = get_posts(array(
        'include'     => $ids,
        'cat'         => $category->cat_ID,
        'numberposts' => $posts_limit,
      ));
    ?>
    <!-- single post -->
    <?php
      foreach ($items as $item) {
        printPost( $item, 'side');
      }
    ?>

  </ul>
</div>
<!-- /Najbardziej popularne-->
