<div class="reportaze">
  <a href="<?php echo get_category_link( get_category_by_slug( 'reportaze' )->cat_ID ); ?>">
    <h5 class="title-sidebar line">Reportaże</h5>
  </a>
  <?php
  $items = get_posts(array(
    'numberposts'     => 14,
    'category_name'   => 'reportaze',
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
