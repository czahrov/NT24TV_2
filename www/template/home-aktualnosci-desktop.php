<?php
  $items = get_posts(array(
    'numberposts'   => 9,
    'category_name' => 'aktualnosci',
    'orderby'       => 'date',
    'order'         => 'DESC'
  ));

?>
<!-- Page Content -->
<div id='aktualnosci' class="<?php echo getDevType(); ?> container">
  <div class="row no-gutters">

    <!-- Blog Entries Column -->
    <div class="col-12 col-lg-8">

      <!-- Big Post -->
      <?php
        printPost( $items[0], 'big' );
      ?>
      <div class="clear-top"></div>

      <div class="row no-gutters">
        <!-- Mid post -->
        <?php
          foreach( array_slice( $items, 1, 3 ) as $item ){
            printPost( $item, 'mid' );
          }
        ?>

      </div>
      <!-- /row-->

    </div>
    <!-- /col-8 -->

    <!-- Sidebar Column -->
    <div class="col-12 col-lg-4 sidebar-list">
      <div class="position-sticky">
        <a href="<?php echo get_category_link( get_category_by_slug('aktualnosci')->cat_ID ); ?>">
          <h5 class="title-sidebar line">Aktualności</h5>
        </a>
        <ul>
          <?php
            foreach ( array_slice( $items, 4 ) as $item) {
              printPost( $item, 'side' );
            }
          ?>
        </ul>
      </div>
    </div>
  </div>
  <!-- /.row -->

  <div class="button-line">
    <a href="<?php echo get_category_link( get_category_by_slug('aktualnosci')->cat_ID ); ?>" class="">Więcej Aktualności</a>
  </div>

  <!-- reklama pozioma -->
  <?php echo printAd('h-l'); ?>
  <!-- <div class="reklama-full-page">
    <div class="reklama">Reklama 1200x150px</div>
  </div> -->

</div>
<!-- /.container -->

<div class="clear-top"></div>
