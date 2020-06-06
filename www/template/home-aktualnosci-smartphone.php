<?php
  // $category = get_category_by_slug('aktualnosci');
  $category = get_category(56);
  $posts_limit = 13;
  $items = get_posts(array(
    'numberposts'   => $posts_limit,
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
<div id='aktualnosci' class="<?php echo getDevType(); ?> container">
  <div class="row no-gutters">
    <!-- Blog Entries Column -->
    <div class="col-12">
      <a href="<?php echo get_category_link( $category->cat_ID ); ?>">
        <h5 class="title-sidebar line"><?php echo $category->name; ?></h5>
      </a>
      <div class="items row no-gutters">
        <!-- Big Post -->
        <?php
          if ( !empty( $items_pined ) ) {
            array_unshift( $items, $items_pined[0] );
            $items = array_slice( $items, 0, $posts_limit );
          }
          printPost( array_splice( $items, 0, 1)[0], 'big', array( 'class' => 'item no-padding' ) );
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

    </div>
    <!-- /col-8 -->
  </div>
  <!-- /.row -->
  <!-- reklama pozioma -->
  <?php echo printAd('h-l'); ?>
  <!-- <div class="reklama-full-page">
    <div class="reklama">Reklama 1200x150px</div>
  </div> -->
</div>
<!-- /.container -->
<div class="clear-top"></div>
