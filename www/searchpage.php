<?php
  /* Template Name: Strona wyszukiwania */
  get_header();

  $search = esc_attr( $_GET['q'] );
  $post_limit = 12;
  $found = get_posts(array(
    'numberposts' => $post_limit,
    's'           => $search,
    'sentence'    => true,
    // 'order'       => 'ASC',
    // 'orderby'     => 'title',
  ));
?>
<div id="search" class="container">
  <h5 class="title-sidebar">
    <?php echo "Wyszukiwana fraza: '{$search}'"; ?>
  </h5>
  <div class="mid_post items row no-gutters">
    <?php foreach ( $found as $item ): ?>
      <?php
        $img = get_the_post_thumbnail_url( $item->ID, 'thumbnail' );
        printf(
          '<div class="item bg-grey-light-hover br-grey-hover col-12 col-sm-6 col-lg-4">
            <a class="wrapper d-flex align-items-center" href="%1$s">
              <div class="cover_img bg-grey flex-shrink-0" style="%2$s"></div>
              <div class="small-post fc-black">
                %4$s
                <span>
                  %3$s
                </span>
              </div>
            </a>
          </div>',
          get_the_permalink( $item->ID ),
          $img !== false?( "background-image:url({$img});" ):( '' ),
          $item->post_title,
          printTags( $item->ID )
        );
      ?>
    <?php endforeach; ?>
  </div>
  <?php if ( count($found) == $post_limit ): ?>
    <button id="btn_more" type="button" name="button" class="col-12 fp-btn btn-more fw-bold position-relative" data-cmd="search">
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
<?php get_footer(); ?>
