<div class="reportaze">
  <h5 class="title-sidebar line">Reportaże</h5>
  <?php
  $items = get_posts(array(
    'numberposts'     => 7,
    'category_name'   => 'reportaze',
  ));
  ?>
  <ul class="image-sidebar-section">

    <!-- single post -->
    <?php
    foreach ( $items as $item ) {
      $format = get_post_format( $item );
      printf(
        '<a href="%s">
          <li>
            <div class="image-container">
              <div class="image" style="background-image:url(%s)">
                %s
              </div>
            </div>
            <span>%s %s</span>
          </li>
        </a>',
        get_permalink( $item->ID ),
        get_the_post_thumbnail_url( $item->ID, 'medium' ),
        $format == 'video'?( '<div class="video-post"></div>' ):( $format == 'gallery'?( '<div class="gallery-post"></div>' ):( '' ) ),
        $item->post_title,
        printTags( $item->ID )
      );
    }
    ?>

  </ul>

</div>
