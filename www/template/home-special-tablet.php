<?php
  global $cat;
  $meta = get_term_meta( $cat->term_id );
  $items = get_posts(array(
    'numberposts'   => 5,
    'cat'           => $cat->term_id,
    'orderby'       => 'date',
    'order'         => 'DESC'
  ));
?>
<!-- Page Content -->
<div id='<?php echo $cat->slug; ?>' class="<?php echo getDevType(); ?> special container" style="background-color:<?php echo $meta['kolor'][0]; ?>">
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
          printPost( $items[0], 'big-special', array( 'class' => 'padding' ) );
        ?>
        <!-- Mid post -->
        <?php
          foreach( array_slice( $items, 1, 1 ) as $item ){
            printPost( $item, 'mid-special', array( 'class' => 'padding' ) );
          }
        ?>
      </div>
    </div>
    <!-- /col-8 -->
    <!-- Sidebar Column -->
    <div class="col-12 col-md-4 sidebar-list">
      <div class="position-sticky">
        <ul class="image-sidebar-section special padding">
          <?php
            foreach ( array_slice( $items, 2 ) as $item) {
              printPost( $item, 'side-special' );
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
