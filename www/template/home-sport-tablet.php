<?php
  $items = get_posts( array(
    'numberposts'     => 5,
    'category_name'   => 'sport'
  ) );
?>
<!-- Page Content -->
<div id="sport" class="<?php echo getDevType(); ?> container">

  <div class="row no-gutters">

    <!-- Blog Entries Column -->
    <div class="col-12 col-md-8">
      <a href="<?php echo get_category_link( get_category_by_slug( 'sport' )->cat_ID ); ?>">
        <h5 class="title-sidebar">Sport</h5>
      </a>
      <div class="row no-gutters">
        <!-- Big Post -->
        <?php
          printPost( $items[0], 'big', array( 'class' => 'padding' ) );
        ?>
        <!-- Mid post -->
        <?php
          foreach( array_slice( $items, 1, 4 ) as $item ){
            printPost( $item, 'mid', array( 'class' => 'padding' ) );
          }
        ?>
      </div>
      <!-- /row-->
      <div class="clear-top"></div>
      <div class="button-line">
        <a href="<?php echo get_category_link( get_category_by_slug( 'sport' )->cat_ID ); ?>" class="">Więcej Sportu</a>
      </div>

    </div>
    <!-- /col-8 -->

    <!-- Sidebar Column -->
    <div class="col-12 col-md-4 sidebar-list">
      <div class="reportaze position-sticky">
        <a href="<?php echo get_category_link( get_category_by_slug( 'kultura' )->cat_ID ); ?>">
          <h5 class="title-sidebar line">Kultura</h5>
        </a>
        <?php
          $items = get_posts( array(
            'numberposts'    => 12,
            'category_name'  => 'kultura'
          ) );
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
      <!-- /kultura -->

    </div>

  </div>
  <!-- /.row -->

</div>
<!-- /.container -->
<div class="clear-top"></div>
