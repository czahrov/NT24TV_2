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
      printf(
        '<a href="%1$s">
          <li>
            <div class="image-container">
              <div class="image pop_1" style="background-image:url(%2$s)"></div>
            </div>
            <span>%3$s</span>
          </li>
        </a>',
        get_permalink( $item),
        get_the_post_thumbnail_url( $item->ID, 'thumbnail' ),
        $item->post_title
      );
    }
    ?>

  </ul>
</div>
<!-- /Najbardziej popularne-->
