<?php
  $items = get_posts(array(
    'numberposts'   => 9,
    'category_name' => 'aktualnosci',
    'orderby'       => 'date',
    'order'         => 'DESC'
  ));

?>
<!-- Page Content -->
<div id='aktualnosci' class="container">
  <div class="row no-gutters">

    <!-- Blog Entries Column -->
    <div class="col-12 col-lg-8">

      <!-- Big Post -->
      <?php
        $item = $items[0];
        printf(
          '<a class="link_post big " href="%1$s">
            <div class="big-post">
              <div class="cover_img img1"></div>
              <div class="post_news_big" style="background-image:url(%2$s)">
                <span>
                  <div class="post-tags">
                    %4$s
                  </div>
                  %3$s
                </span>
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
        <!-- Mid post -->
        <?php
          foreach( array_slice( $items, 1, 3 ) as $item ){
            printf(
              '<div class="col col-lg-4">
                <a href="%1$s" class="link_post_small">
                  <div class="small-post">
                    <div class="post_news_small">
                      <div class="cover_img img2" style="background-image:url(%2$s)"></div>
                    </div>
                    <span>%4$s %3$s</span>
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

    </div>
    <!-- /col-8 -->

    <!-- Sidebar Column -->
    <div class="col-12 col-lg-4 sidebar-list">
      <h5 class="title-sidebar line">Aktualności</h5>
      <ul>
        <?php
          foreach ( array_slice( $items, 4 ) as $item) {
            printf(
              '<a href="%1$s">
                <li>%4$s %2$s
                  <span class="data">%3$s</span>
                  </span>
                </li>
              </a>',
              get_permalink( $item->ID ),
              $item->post_title,
              get_the_date( "d.m.Y", $item->ID ),
              printTags( $item->ID )
            );
          }
        ?>
      </ul>
    </div>
  </div>
  <!-- /.row -->

  <div class="button-line">
    <a href="<?php echo get_category_link( get_category_by_slug('aktualnosci')->cat_ID ); ?>" class="">Więcej Aktualności</a>
  </div>

  <div class="reklama-full-page">
    <!-- <div class="reklama">Reklama 1200x150px</div> -->
    <?php echo printAd('pozioma'); ?>
  </div>

</div>
<!-- /.container -->

<div class="clear-top"></div>
