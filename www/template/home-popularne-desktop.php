<?php
  $items = get_posts( array(
    'numberposts'     => 4,
    'category_name'   => 'popularne',
    'orderby'         => 'date',
    'order'           => 'DESC',
  ) );
?>
<!-- Page Content -->
<div id='popularne' class="<?php echo getDevType(); ?> container">

  <div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-12 col-lg-8">
      <h5 class="title-sidebar">Najbardziej pupularne</h5>
      <!-- Post -->
      <div class="row no-gutters padding najbardziej-popularne">
        <!-- single post -->
        <?php
          foreach ($items as $item) {
            printPost( $item, 'large' );
          }
        ?>

      </div>
      <div class="arrows d-flex justify-content-between"> </div>

    </div>
    <!-- /col-8 -->

    <!-- Sidebar Column -->
    <div class="col-md-12 col-lg-4 sidebar-list no-padding">
      <div id="" class="position-sticky">
        <!-- reklama pionowa -->
        <?php echo printAd( 'v-l' ); ?>
        <!-- <div class="reklama-sidebar sticky">
          <div class="reklama">Reklama 400x700px</div>
        </div> -->
      </div>

    </div>

  </div>
  <!-- /.row -->

</div>
<!-- /.container -->
<div class="clear-top"></div>
