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
<div id="search" class="<?php echo getDevType(); ?> container padding-md">
  <h5 class="title-sidebar">
    <?php echo "Wyszukiwana fraza: '{$search}'"; ?>
  </h5>
  <div class="items row no-gutters">
    <!-- MID POSTS -->
    <?php
      foreach ( $found as $num => $item ){
        switch ( getDevType() ) {
          case 'desktop':
            $img_size = 'medium';
            break;
          case 'tablet':
          case 'smartphone':
            $img_size = 'thumbnail';
            break;
          default:
            $img_size = 'full';
            break;
        }
        printPost( $item, 'mid', array( 'img_size' => $img_size, 'class'=> 'item' ) );
      }
    ?>
    <!-- /row-->
    <?php if ( count($found) == $post_limit ): ?>
      <button id="btn_more" type="button" name="button" class="col-12 fp-btn btn-more fw-bold position-relative" data-cmd="search">
        <div class="spinner position-absolute">
          <div class="box position-absolute"> </div>
        </div>
        Załaduj więcej
      </button>
    <?php endif; ?>
  </div>
  <?php if( count( $found ) == 0 ): ?>
    <div class="fc-red col-12 text-center">
      Nie znaleziono podanej frazy
    </div>
  <?php endif; ?>
</div>
<?php get_footer(); ?>
