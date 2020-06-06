<?php
  $category = get_category( 74 );
  $posts_limit = 10;
  $items = get_posts(array(
    'numberposts'     => $posts_limit,
    'cat'             => $category->cat_ID,
  ));
  $items_pined = get_posts(array(
    'numberposts'   => 1,
    'cat'           => $category->cat_ID,
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
<div id='przeglad_tygodniowy' class="<?php echo getDevType(); ?> container">
  <div class="row no-gutters">
    <!-- Blog Entries Column -->
    <div class="col-12 col-sm-8">
      <a href="<?php echo get_category_link( $category->cat_ID ); ?>">
        <h5 class="title-sidebar"><?php echo $category->name; ?></h5>
      </a>
      <div class="row no-gutters padding">
        <!-- Big Post -->
        <?php
          if ( !empty( $items_pined ) ) {
            array_unshift( $items, $items_pined[0] );
            $items = array_slice( $items, 0, $posts_limit );
          }
          printPost( array_splice( $items, 0, 1 )[0], 'big', array( 'class' => '' ) );
        ?>
        <!-- Mid post -->
        <?php
          foreach( array_splice( $items, 0, 4 ) as $item ){
            printPost( $item, 'mid', array( 'class' => '' ) );
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

      <!-- reklama pozioma -->
      <?php echo printAd('h-m'); ?>
      <!-- <div class="reklama-full-page">
        <div class="reklama">Reklama 840x150px</div>
      </div> -->

    </div>
    <!-- /col-8 -->
    <!-- Sidebar Column -->
    <div class="col-12 col-sm-4 sidebar-list">
      <a href="<?php echo get_permalink( 108566 ); ?>">
        <h5 class="title-sidebar">Stan powietrza Nowy Targ</h5>
      </a>
      <?php get_template_part('template/airly'); ?>

      <div class="clear-top"></div>
      <div class="position-sticky">
        <?php
          // get_template_part('template/sidebar-reportaze-tablet');
          templateLoader('template/sidebar-reportaze-%s');
        ?>
      </div>
      <!-- /reportaże -->

    </div>
  </div>
  <!-- /.row -->

</div>
<!-- /.container -->
<div class="clear-top"></div>
