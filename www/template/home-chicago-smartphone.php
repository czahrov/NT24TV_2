<?php
  // Wiadomości prosto z Chicago
  $category_chicago = get_category( 280 );
  // $category = get_category( 81 );
  $posts_limit = 13;
  $items = get_posts( array(
    'numberposts'     => $posts_limit,
    'cat'             => $category_chicago->cat_ID,
  ) );
  $items_pined = get_posts(array(
    'numberposts'   => 1,
    'cat'           => $category_chicago->term_id,
    'orderby'       => 'date',
    'order'         => 'DESC',
    'meta_key'      => 'pin',
    'meta_value'    => '1',
  ));
?>
<!-- Page Content -->
<div id="chicago" class="<?php echo getDevType(); ?> container">
  <div class="row no-gutters">
    <!-- Blog Entries Column -->
    <div class="col-12">
      <a href="<?php echo get_category_link( $category_chicago->cat_ID ); ?>">
        <h5 class="title-sidebar"><?php echo $category_chicago->name; ?></h5>
      </a>
      <div class="items row no-gutters">
        <!-- Mid post -->
        <?php
          if ( !empty( $items_pined ) ) {
            array_unshift( $items, $items_pined[0] );
            $items = array_slice( $items, 0, $posts_limit );
          }
          foreach( array_splice( $items, 0, 12 ) as $item ){
            printPost( $item, 'mid', array( 'class' => 'item' ) );
          }
        ?>
        <button id="btn_more" class="col-12 fp-btn btn-more fw-bold position-relative" type="button" name="button" data-cmd="posts" data-category="<?php echo $category_chicago->slug; ?>">
          <div class="spinner position-absolute">
            <div class="box position-absolute"> </div>
          </div>
          Załaduj więcej
        </button>
        <!-- /row-->
      </div>
    </div>
    <!-- /col-8 -->

    <!-- Sidebar Column -->
    <div class="col-12 sidebar-list">
      <div class="reportaze sticky">
        <?php
          $category_ekologia = get_category( 81 );
        ?>
        <a href="<?php echo get_category_link( $category_ekologia->cat_ID ); ?>">
          <h5 class="title-sidebar line"><?php echo $category_ekologia->name; ?></h5>
        </a>
        <?php
          $items = get_posts( array(
            'numberposts'    => 8,
            'cat'             => $category_ekologia->cat_ID,
          ) );
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
      <!-- /kultura -->

    </div>
  </div>
  <!-- /.row -->
</div>
<!-- /.container -->
<div class="clear-top"></div>
