<div id="nadchodzace" class="<?php echo getDevType(); ?> single-post sidebar-list padding-md">
  <a href="<?php echo get_category_link( get_category_by_slug( 'bedzie-sie-dzialo' )->cat_ID ); ?>">
    <h5 class="title-sidebar">Będzie się działo</h5>
  </a>
  <ul class="image-sidebar-section">
    <?php
      $date_now = date( 'Y-m-d H:i' );
      $items = get_posts(array(
        'numberposts'   => 17,
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
