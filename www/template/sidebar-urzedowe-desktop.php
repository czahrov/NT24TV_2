<div id="urzedowe" class="<?php echo getDevType(); ?>">
  <h5 class="title-sidebar line">Ogłoszenia urzędowe</h5>
  <ul class="image-sidebar-section">
    <?php
      $items = get_posts(array(
        'numberposts'   => 4,
        'category_name' => 'ogloszenia-urzedowe',
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
