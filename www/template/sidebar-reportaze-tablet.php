<div class="reportaze">
  <a href="<?php echo get_category_link( 61 ); ?>">
    <h5 class="title-sidebar line">Reportaże</h5>
  </a>
  <?php
  $items = get_posts(array(
    'numberposts'     => 8,
    'cat'             => 61,
  ));
  ?>
  <ul class="image-sidebar-section">

    <!-- single post -->
    <?php
    foreach ( $items as $item ) {
      printPost( $item, 'side' );
    }
    ?>

  </ul>

</div>
