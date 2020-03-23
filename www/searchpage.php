<?php
  /* Template Name: Strona wyszukiwania */
  get_header();

  $search = esc_attr( $_GET['q'] );
  $post_limit = 12;
  $found = get_posts(array(
    'numberposts' => $post_limit,
    's'           => $search,
    // 'sentence'    => true,
    // 'order'       => 'ASC',
    // 'orderby'     => 'title',
  ));
?>
<div id="search" class="container">
  <h5 class="title-sidebar">
    <?php echo "Wyszukiwana fraza: '{$search}'"; ?>
  </h5>
  <div class="tiles row">
    <?php foreach ( $found as $item ): ?>
      <?php
        $img = get_the_post_thumbnail_url( $item->ID, 'thumbnail' );
        printf(
          '<a class="tile bg-grey-light-hover br-grey-hover col-12 col-sm-6 col-lg-4" href="%1$s">
            <div class="wrapper d-flex align-items-center">
              <div class="img bg-grey flex-shrink-0" style="%2$s"></div>
              <div class="title fc-black">%4$s %3$s</div>
            </div>
          </a>',
          get_the_permalink( $item->ID ),
          $img !== false?( "background-image:url({$img});" ):( '' ),
          $item->post_title,
          printTags( $item->ID )
        );
      ?>
    <?php endforeach; ?>
    <?php if ( count($found) == $post_limit ): ?>
      <button id="btn_more" type="button" name="button" class="col-12 fp-btn btn-more fw-bold position-relative">
        <div class="spinner position-absolute">
          <div class="box position-absolute"> </div>
        </div>
        Załaduj więcej
      </button>
    <?php elseif( count( $found ) == 0 ): ?>
      <div class="fc-red col-12 text-center">
        Nie znaleziono podanej frazy
      </div>
    <?php endif; ?>
  </div>
</div>
<?php get_footer(); ?>
