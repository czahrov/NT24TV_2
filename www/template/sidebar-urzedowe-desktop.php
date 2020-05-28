<div id="urzedowe" class="<?php echo getDevType(); ?>">
  <a href="<?php echo get_category_link( get_category_by_slug( 'ogloszenia-urzedowe' )->cat_ID ); ?>">
    <h5 class="title-sidebar line">Ogłoszenia urzędowe</h5>
  </a>
  <ul class="image-sidebar-section">
    <?php
      $items = get_posts(array(
        'numberposts'   => 8,
        'category_name' => 'ogloszenia-urzedowe',
      ));
    ?>
    <!-- single post -->
    <?php
      foreach ($items as $item) {
        printPost( $item, 'side' );
      }
    ?>

  </ul>
</div>
