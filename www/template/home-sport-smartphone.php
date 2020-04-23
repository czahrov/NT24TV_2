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
      <h5 class="title-sidebar">Sport</h5>

      <!-- BIG Post -->
      <?php
        $item = $items[0];
        printf(
          '<a class="link_post big" href="%s">
            <div class="big-post">
              <div class="cover_img"></div>
              <div class="post_news_big" style="background-image:url(%s)">
                <span>%s %s</span>
              </div>
            </div>
          </a>',
          get_permalink( $item->ID ),
          get_the_post_thumbnail_url( $item->ID, 'full' ),
          $item->post_title,
          printTags( $item->ID, false )
        );
      ?>
      <div class="clear-top"></div>
      <div class="mid_post row no-gutters">
        <!-- MID post -->
        <?php
          foreach ( array_slice( $items, 1 ) as $item ) {
            printf(
              '<div class="item col-6 col-md-4">
                <a href="%s" class="link_post_small">
                  <div class="small-post">
                    <div class="post_news_small">
                      <div class="cover_img" style="background-image:url(%s)"></div>
                    </div>
                    <span>%s %s</span>
                  </div>
                </a>
              </div>',
              get_permalink( $item->ID ),
              get_the_post_thumbnail_url( $item->ID, 'large' ),
              $item->post_title,
              printTags( $item->ID )
            );
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
        <h5 class="title-sidebar line">Kultura</h5>
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
              printf(
                '<a class="col-12 col-sm-6" href="%s">
                  <li>
                    <div class="image-container">
                      <div class="image" style="background-image:url(%s)"></div>
                    </div>
                    <span>%s %s</span>
                  </li>
                </a>',
                get_permalink( $item->ID ),
                get_the_post_thumbnail_url( $item->ID, 'thumbnail' ),
                $item->post_title,
                printTags( $item->ID )
              );
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
