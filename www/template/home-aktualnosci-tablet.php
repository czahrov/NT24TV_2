<?php
  $category = get_category(56);
  $items = get_posts(array(
    'numberposts'   => 22,
    'cat'           => $category->term_id,
    'orderby'       => 'date',
    'order'         => 'DESC'
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
<div id='aktualnosci' class="<?php echo getDevType(); ?> container padding">
  <div class="row no-gutters">
    <!-- Blog Entries Column -->
    <div class="col-12 col-md-8">
      <div class="row no-gutters">
        <!-- Big Post -->
        <?php
          if ( !empty( $items_pined ) ) {
            array_unshift( $items, $items_pined[0] );
            $items = array_slice( $items, 0, $posts_limit );
          }
          printPost( array_splice( $items, 0, 1 )[0], 'big', array( 'img_size' => 'thumbnail', 'class' => '' ) );
        ?>
        <!-- Mid post -->
        <?php
          foreach( array_splice( $items, 0, 7 ) as $item ){
            printPost( $item, 'mid', array( 'img_size' => 'thumbnail', 'class' => '' ) );
          }
        ?>
      </div>
    </div>
    <!-- /col-8 -->
    <!-- Sidebar Column -->
    <div class="col-12 col-md-4 sidebar-list">
      <div class="position-sticky">
        <a href="<?php echo get_category_link( $category->cat_ID ); ?>">
          <h5 class="title-sidebar line"><?php echo $category->name; ?></h5>
        </a>
        <ul class="image-sidebar-section alt">
          <?php
            foreach ( array_splice( $items, 0 ) as $item) {
              printPost( $item, 'side', array( 'img_size' => 'thumbnail' ) );
            }
          ?>
        </ul>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <div class="button-line">
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
  <?php echo printAd('h-l'); ?>
  <!-- <div class="reklama-full-page">
    <div class="reklama">Reklama 1200x150px</div>
  </div> -->
</div>
<!-- /.container -->
<div class="clear-top"></div>
