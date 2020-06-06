<?php
  // Wiadomości prosto z Chicago
  // $category = get_category( 286 );
  $category = get_category( 81 );
  $posts_limit = 22;
  $items = get_posts( array(
    'numberposts'     => $posts_limit,
    'cat'             => $category->cat_ID,
  ) );
  $items_pined = get_posts(array(
    'numberposts'   => 1,
    'cat'           => $category->cat_ID,
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
    <div class="col-12 col-sm-8">
      <a href="<?php echo get_category_link( $category->cat_ID ); ?>">
        <h5 class="title-sidebar"><?php echo $category->name; ?></h5>
      </a>
      <div class="row no-gutters padding">
        <!-- Mid post -->
        <?php
          if ( !empty( $items_pined ) ) {
            array_unshift( $items, $items_pined[0] );
            $items = array_slice( $items, 0, $posts_limit );
          }
          foreach( array_splice( $items, 0, 6 ) as $item ){
            printPost( $item, 'mid', array( 'class' => 'item' ) );
          }
        ?>
      </div>
      <!-- /row-->
      <div class="clear-top"></div>
      <div class="button-line padding">
        <a href="<?php echo get_category_link( $category->cat_ID ); ?>" class="">
          <?php
            printf(
              'Więcej %s',
              strtolower( $category->name )
            );
          ?>
        </a>
      </div>

    </div>
    <!-- /col-8 -->
    <!-- Sidebar Column -->
    <div class="col-12 col-sm-4 sidebar-list">
      <div class="position-sticky">
        <ul class="image-sidebar-section alt">

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
