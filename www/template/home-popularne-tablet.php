<?php
  $items = get_posts( array(
    'numberposts'     => 4,
    'category_name'   => 'popularne',
    'orderby'         => 'date',
    'order'           => 'DESC',
  ) );
?>
<!-- Page Content -->
<div id='popularne' class="<?php echo getDevType(); ?> container padding">

  <div class="row no-gutters">

    <!-- Blog Entries Column -->
    <div class="col-12">
      <h5 class="title-sidebar">Najbardziej popularne</h5>
      <!-- Post -->
      <div class="slick row no-gutters najbardziej-popularne">
        <!-- single post -->
        <?php
          foreach ($items as $item) {
            printPost( $item, 'large', array( 'class' => 'no-padding' ) );
          }
        ?>
        <?php echo printAd( 'v-l' ); ?>

      </div>
      <div class="arrows d-flex justify-content-between"> </div>
    </div>
    <!-- /col-8 -->

  </div>
  <!-- /.row -->

</div>
<!-- /.container -->
<div class="clear-top"></div>
