<?php
  $category_sport = get_category(58);
  $posts_limit = 13;
  $items = get_posts( array(
    'numberposts'     => $posts_limit,
    'category_name'   => 'sport'
  ) );
  $items_pined = get_posts(array(
    'numberposts'   => 1,
    'cat'           => $category_sport->cat_ID,
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
<div id="sport" class="<?php echo getDevType(); ?> container">

  <div class="row no-gutters">

    <!-- Blog Entries Column -->
    <div class="col-12">
      <a href="<?php echo get_category_link( $category_sport->cat_ID ); ?>">
        <h5 class="title-sidebar"><?php echo $category_sport->name; ?></h5>
      </a>
      <div class="items row no-gutters">
        <!-- Big Post -->
        <?php
          if ( !empty( $items_pined ) ) {
            array_unshift( $items, $items_pined[0] );
            $items = array_slice( $items, 0, $posts_limit );
          }
          printPost( $items[0], 'big', array( 'img_size' => 'medium', 'class' => 'item no-padding' ) );
        ?>
        <!-- Mid post -->
        <?php
          foreach( array_slice( $items, 1 ) as $item ){
            printPost( $item, 'mid', array( 'img_size' => 'thumbnail', 'class' => 'item' ) );
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

    <!-- Sidebar Column -->
    <div class="col-12 sidebar-list">
      <div class="reportaze sticky">
        <?php
          $category_kultura = get_category(59);
        ?>
        <a href="<?php echo get_category_link( $category_kultura->cat_ID ); ?>">
          <h5 class="title-sidebar line"><?php echo $category_kultura->name; ?></h5>
        </a>
        <?php
          $items = get_posts( array(
            'numberposts'    => 8,
            'cat'             => $category_kultura->cat_ID,
          ) );
        ?>
        <ul class="image-sidebar-section row no-gutters">

          <!-- single post -->
          <?php
            foreach ( $items as $item ) {
              printPost( $item, 'side', array( 'img_size' => 'thumbnail' ) );
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
