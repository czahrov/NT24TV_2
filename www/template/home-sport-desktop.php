<?php
  $category_sport = get_category(58);
  $posts_limit = 5;
  $items = get_posts( array(
    'numberposts'     => $posts_limit,
    'category_name'   => 'sport'
  ) );
  $items_pined = get_posts(array(
    'numberposts'   => 1,
    'cat'           => $category_sport->cat_ID,
    'orderby'       => 'date',
    'order'         => 'DESC',
    'meta_query' => array(
      array(
        'relation' => 'AND',
        array(
          'key'   => 'home',
          'value' => 1,
        ),
        array(
          'relation'  => 'AND',
          array(
            'key'   => 'pin',
            'value' => 1,
          ),
        )
      ),
    ),
  ));
?>
<!-- Page Content -->
<div id="sport" class="<?php echo getDevType(); ?> container">

  <div class="row no-gutters">

    <!-- Blog Entries Column -->
    <div class="col-12 col-sm-8">
      <a href="<?php echo get_category_link( $category_sport->cat_ID ); ?>">
        <h5 class="title-sidebar"><?php echo $category_sport->name; ?></h5>
      </a>
      <div class="row no-gutters padding">
        <!-- Big Post -->
        <?php
        if ( !empty( $items_pined ) ) {
          array_unshift( $items, $items_pined[0] );
          $items = array_slice( $items, 0, $posts_limit );
        }
        printPost( array_splice( $items, 0, 1)[0], 'big', array( 'img_size' => 'medium', 'class' => '' ) );
        ?>
        <!-- Mid post -->
        <?php
          foreach( array_splice( $items, 0, 4 ) as $item ){
            printPost( $item, 'mid', array( 'img_size' => 'thumbnail', 'class' => '' ) );
          }
        ?>
      </div>
      <!-- /row-->
      <div class="clear-top"></div>
      <div class="button-line padding">
        <a href="<?php echo get_category_link( $category_sport->cat_ID ); ?>" class="">
          <?php
            printf(
              'Więcej %s',
              strtolower( $category_sport->name )
            );
          ?>
        </a>
      </div>

    </div>
    <!-- /col-8 -->

    <!-- Sidebar Column -->
    <div class="col-12 col-sm-4 sidebar-list">
      <div class="reportaze position-sticky">
        <?php
          $category_kultura = get_category(59);
        ?>
        <a href="<?php echo get_category_link( $category_kultura->cat_ID ); ?>">
          <h5 class="title-sidebar line"><?php echo $category_kultura->name; ?></h5>
        </a>
        <?php
          $items = get_posts( array(
            'numberposts'    => 12,
            'cat'             => $category_kultura->cat_ID,
          ) );
        ?>
        <ul class="image-sidebar-section alt">

          <!-- single post -->
          <?php
            foreach ( $items as $item ) {
              printPost( $item, 'side', array( 'img_size' => 'thumbnail' ) );
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
