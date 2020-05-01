<?php
  $category = get_category_by_slug('sport');
  $items = get_posts( array(
    'numberposts'   => 13,
    'cat'           => $category->term_id,
  ) );
?>
<!-- Page Content -->
<div id="sport" class="<?php echo getDevType(); ?> container">

  <div class="row no-gutters">

    <!-- Blog Entries Column -->
    <div class="col-12">
      <a href="<?php echo get_category_link( get_category_by_slug( 'sport' )->cat_ID ); ?>">
        <h5 class="title-sidebar">Sport</h5>
      </a>

      <!-- BIG Post -->
      <?php
        printPost( $items[0], 'big' );
      ?>
      <div class="clear-top"></div>
      <div class="mid_post row no-gutters">
        <!-- MID post -->
        <?php
          foreach ( array_slice( $items, 1 ) as $item ) {
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
      <div class="clear-top"></div>

    </div>
    <!-- /col-8 -->

    <!-- Sidebar Column -->
    <div class="col-12 sidebar-list">
      <div class="reportaze sticky">
        <a href="<?php echo get_category_link( get_category_by_slug( 'kultura' )->cat_ID ); ?>">
          <h5 class="title-sidebar line">Kultura</h5>
        </a>
        <?php
          $items = get_posts( array(
            'numberposts'    => 8,
            'category_name'  =>   'kultura'
          ) );
        ?>
        <ul class="image-sidebar-section row no-gutters">

          <!-- single post -->
          <?php
            foreach ( $items as $item ) {
              printPost( $item, 'side' );
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
