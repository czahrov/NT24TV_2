<?php
  $category = get_category_by_slug('przeglad-tygodniowy');
  $items = get_posts(array(
    'numberposts'   => 13,
    'cat'           => $category->term_id,
  ));
?>
<!-- Page Content -->
<div id='przeglad_tygodniowy' class="<?php echo getDevType(); ?> container">
  <div class="row no-gutters">
<!-- Blog Entries Column -->
    <div class="col-12">
      <a href="<?php echo get_category_link( $category->cat_ID ); ?>">
        <h5 class="title-sidebar">Przegląd tygodniowy</h5>
      </a>
      <!-- BIG Post -->
      <div class="items row no-gutters">
        <!-- Big Post -->
        <?php
          if ( !empty( $items_pined ) ) {
            array_unshift( $items, $items_pined[0] );
            $items = array_slice( $items, 0, $posts_limit );
          }
          printPost( $items[0], 'big-special', array( 'class' => 'item no-padding' ) );
        ?>
        <!-- Mid post -->
        <?php
          foreach( array_slice( $items, 1 ) as $item ){
            printPost( $item, 'mid-special', array( 'class' => 'item' ) );
          }
        ?>

        <button id="btn_more" class="col-12 fp-btn btn-more fw-bold position-relative" type="button" name="button" data-cmd="posts" data-category="<?php echo $category->slug; ?>">
          <div class="spinner position-absolute">
            <div class="box position-absolute"> </div>
          </div>
          Załaduj więcej
        </button>
        <!-- /row-->
      </div>

      <!-- reklama pozioma -->
      <?php echo printAd('h-m'); ?>
      <!-- <div class="reklama-full-page">
        <div class="reklama">Reklama 840x150px</div>
      </div> -->

    </div>
    <!-- /col-8 -->
<!-- Sidebar Column -->
    <div id="" class="sidebar col-12 sidebar-list">
      <a href="<?php echo get_permalink( get_page_by_title( 'Pogoda' )->ID ); ?>">
        <h5 class="title-sidebar">Stan powietrza Nowy Targ</h5>
      </a>

      <?php get_template_part('template/airly'); ?>

      <div class="reportaze sticky">
        <div class="clear-top"></div>
        <a href="<?php echo get_category_link( get_category_by_slug( 'reportaze' )->cat_ID ); ?>">
          <h5 class="title-sidebar line">Reportaże</h5>
        </a>
        <?php
          $items = get_posts(array(
            'numberposts'     => 8,
            'category_name'   => 'reportaze',
          ));
        ?>
        <ul class="image-sidebar-section row no-gutters">

          <!-- single post -->
          <?php
            foreach ( $items as $item ) {
              printPost( $item, 'side' );
            }
          ?>

        </ul>

      </div>
      <!-- /reportaże -->

    </div>
  </div>
  <!-- /.row -->

</div>
<!-- /.container -->
<div class="clear-top"></div>
