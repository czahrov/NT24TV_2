<?php
  $category = get_category_by_slug('aktualnosci');
  $items = get_posts(array(
    'numberposts'   => 13,
    'cat'           => $category->term_id,
    'orderby'       => 'date',
    'order'         => 'DESC'
  ));
?>
<!-- Page Content -->
<div id='aktualnosci' class="<?php echo getDevType(); ?> container">
  <div class="row no-gutters">
    <!-- Blog Entries Column -->
    <div class="col-12">
      <a href="<?php echo get_category_link( get_category_by_slug('aktualnosci')->cat_ID ); ?>">
        <h5 class="title-sidebar line">Aktualności</h5>
      </a>
      <!-- Big Post -->
      <?php
        printPost( $items[0],'big' );
      ?>
      <div class="clear-top"></div>

      <div class="mid_post row no-gutters">
        <!-- Mid post -->
        <?php
          foreach( array_slice( $items, 1 ) as $item ){
            printPost( $item, 'mid' );
          }
        ?>

      </div>
      <!-- /row-->
      <button id="btn_more" class="col-12 fp-btn btn-more fw-bold position-relative" type="button" name="button" data-cmd="posts" data-category="<?php echo $category->slug ?>">
        <div class="spinner position-absolute">
          <div class="box position-absolute"> </div>
        </div>
        Załaduj więcej
      </button>

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
