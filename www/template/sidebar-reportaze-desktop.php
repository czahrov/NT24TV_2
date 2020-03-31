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
        '<a href="%1$s">
        <li>
        <div class="image-container">
        <div class="image img5" style="background-image:url(%2$s)">
        %4$s
        </div>
        </div>
        <span>%5$s %3$s</span>
        </li>
        </a>',
        get_permalink( $item->ID ),
        get_the_post_thumbnail_url( $item->ID, 'medium' ),
        $item->post_title,
        $format == 'video'?( '<div class="video-post"></div>' ):( $format == 'gallery'?( '<div class="gallery-post"></div>' ):( '' ) ),
        printTags( $item->ID )
      );
    }
    ?>

  </ul>

</div>
