<?php
  global $cat;
  $posts_limit = 5;
  $meta = get_term_meta( $cat->term_id );
  $items = get_posts(array(
    'numberposts'   => $posts_limit,
    'cat'           => $cat->term_id,
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
<div id='<?php echo $cat->slug; ?>' class="<?php echo getDevType(); ?> special container padding" style="background-color:<?php echo $meta['kolor'][0]; ?>">
  <a href="<?php echo get_category_link( $cat->term_id ); ?>">
    <h5 class="title-sidebar">
      <?php echo $cat->name; ?>
    </h5>
  </a>
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
          printPost( $items[0], 'big-special', array(
            'img_size' => 'medium',
            'pasek' => $meta['pasek'][0],
          ) );
        ?>
        <!-- Mid post -->
        <?php
          foreach( array_slice( $items, 1, 1 ) as $item ){
            printPost( $item, 'mid-special', array(
              'img_size' => 'thumbnail',
              'class' => '',
            ) );
          }
        ?>
      </div>
    </div>
    <!-- /col-8 -->
    <!-- Sidebar Column -->
    <div class="col-12 col-md-4 sidebar-list">
      <div class="position-sticky">
        <ul class="image-sidebar-section special">
          <?php
            foreach ( array_slice( $items, 2 ) as $item) {
              printPost( $item, 'side-special', array(
                'img_size' => 'thumbnail',
                // 'title_limit' => 6,
              ) );
            }
          ?>
        </ul>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <div class="button-line">
    <a href="<?php echo get_category_link( $cat->term_id ); ?>" class="">Zobacz więcej</a>
  </div>
</div>
<!-- reklama pozioma -->
<?php echo printAd('h-l'); ?>
<!-- <div class="reklama-full-page">
<div class="reklama">Reklama 1200x150px</div>
</div> -->
<!-- /.container -->
<div class="clear-top"></div>
