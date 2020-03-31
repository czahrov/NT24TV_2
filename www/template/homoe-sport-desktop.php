<?php
  $items = get_posts( array(
    'numberposts'     => 4,
    'category_name'   => 'sport'
  ) );
?>
<!-- Page Content -->
<div id="sport" class="<?php echo getDevType(); ?> container">

  <div class="row no-gutters">

    <!-- Blog Entries Column -->
    <div class="col-12 col-lg-8">
      <h5 class="title-sidebar">Sport</h5>

      <!-- BIG Post -->
      <?php
        $item = $items[0];
        printf(
          '<a class="link_post big" href="%1$s">
            <div class="big-post">
              <div class="cover_img"></div>
              <div class="post_news_big  img24" style="background-image:url(%2$s)">
                <span>%4$s %3$s</span>
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
      <div class="row no-gutters">
        <!-- MID post -->
        <?php
          foreach ( array_slice( $items, 1 ) as $item ) {
            printf(
              '<div class="col col-lg-4">
                <a href="%1$s" class="link_post_small">
                  <div class="small-post">
                    <div class="post_news_small">
                      <div class="cover_img img25" style="background-image:url(%3$s)"></div>
                    </div>
                    <span>%4$s %2$s</span>
                  </div>
                </a>
              </div>',
              get_permalink( $item->ID ),
              $item->post_title,
              get_the_post_thumbnail_url( $item->ID, 'large' ),
              printTags( $item->ID )
            );
          }
        ?>

      </div>
      <!-- /row-->
      <div class="clear-top"></div>
      <div class="button-line">
        <a href="<?php echo get_category_link( get_category_by_slug( 'sport' )->cat_ID ); ?>" class="">Więcej Sportu</a>
      </div>

    </div>
    <!-- /col-8 -->

    <!-- Sidebar Column -->
    <div class="col-12 col-lg-4 sidebar-list">
      <div class="reportaze position-sticky">
        <h5 class="title-sidebar line">Kultura</h5>
        <?php
          $items = get_posts( array(
            'numberposts'    => 6,
            'category_name'  =>   'kultura'
          ) );
        ?>
        <ul class="image-sidebar-section">

          <!-- single post -->
          <?php
            foreach ( $items as $item ) {
              printf(
                '<a href="%1$s">
                  <li>
                    <div class="image-container">
                      <div class="image img19" style="background-image:url(%2$s)"></div>
                    </div>
                    <span>%4$s %3$s</span>
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
