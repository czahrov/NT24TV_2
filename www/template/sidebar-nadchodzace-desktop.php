<div id="nadchodzace" class="<?php echo getDevType(); ?> single-post sidebar-list padding">
  <a href="<?php echo get_category_link( get_category_by_slug( 'bedzie-sie-dzialo' )->cat_ID ); ?>">
    <h5 class="title-sidebar">Będzie się działo</h5>
  </a>
  <ul class="image-sidebar-section">
    <?php
      $items = get_posts(array(
        'numberposts'   => 11,
        'category_name' => 'bedzie-sie-dzialo',
      ));
    ?>
    <!-- single post -->
    <?php
      foreach ($items as $item) {
        printf(
          '<a href="%1$s">
            <li>
              <div class="image-container">
                <div class="image img19" style="background-image:url(%3$s);"></div>
              </div>
              <span>%4$s %2$s</span>
            </li>
          </a>',
          get_permalink( $item->ID ),
          $item->post_title,
          get_the_post_thumbnail_url( $item->ID, 'thumbnail' ),
          printTags( $item->ID )
        );
      }
    ?>

  </ul>
</div>
