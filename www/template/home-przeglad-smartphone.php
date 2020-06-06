<?php
  $category = get_category( 74 );
  $posts_limit = 13;
  $items = get_posts(array(
    'numberposts'     => $posts_limit,
    'cat'             => $category->cat_ID,
  ));
  $items_pined = get_posts(array(
    'numberposts'   => 1,
    'cat'           => $category->term_id,
    'orderby'       => 'date',
    'order'         => 'DESC',
    'meta_key'      => 'pin',
    'meta_value'    => '1',
  ));
?>
<!-- Page Content -->
<div id='przeglad_tygodniowy' class="<?php echo getDevType(); ?> container">
  <div class="row no-gutters">
<!-- Blog Entries Column -->
    <div class="col-12">
      <a href="<?php echo get_category_link( $category->cat_ID ); ?>">
        <h5 class="title-sidebar"><?php echo $category->name; ?></h5>
      </a>
      <!-- BIG Post -->
      <div class="items row no-gutters">
        <!-- Big Post -->
        <?php
          if ( !empty( $items_pined ) ) {
            array_unshift( $items, $items_pined[0] );
            $items = array_slice( $items, 0, $posts_limit );
          }
          printPost( array_splice( $items, 0, 1 )[0], 'big', array( 'class' => 'item no-padding' ) );
        ?>
        <!-- Mid post -->
        <?php
          foreach( array_splice( $items, 0 ) as $item ){
            printPost( $item, 'mid', array( 'class' => 'item' ) );
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
      <a href="<?php echo get_permalink( 108566 ); ?>">
        <h5 class="title-sidebar">Stan powietrza Nowy Targ</h5>
      </a>

      <?php get_template_part('template/airly'); ?>

      <div class="reportaze sticky">
        <div class="position-sticky">
          <?php
            // get_template_part('template/sidebar-reportaze-tablet');
            templateLoader('template/sidebar-reportaze-%s');
          ?>
        </div>
      </div>
      <!-- /reportaże -->

    </div>
  </div>
  <!-- /.row -->

</div>
<!-- /.container -->
<div class="clear-top"></div>
