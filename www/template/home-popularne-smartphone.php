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

  <div class="row no-gutters">

    <!-- Blog Entries Column -->
    <div class="col-md-12">

      <h5 class="title-sidebar">Najbardziej popularne</h5>

      <!-- Post -->
      <div class="slick row no-gutters najbardziej-popularne">
        <!-- single post -->
        <?php
          foreach ($items as $item) {
            $format = get_post_format( $item );
            printf(
              '<div class="col-12 col-md-6 no-padding">
                <a href="%2$s" class="link_post_small">
                  <div class="small-post popular-post">
                    %4$s
                    <span>%5$s %1$s</span>
                    <div class="post_news_small">
                      <div class="mask-popular"></div>
                      <div class="cover_img" style="background-image:url(%3$s);"></div>
                    </div>
                  </div>
                </a>
              </div>',
              $item->post_title,
              get_permalink( $item->ID ),
              get_the_post_thumbnail_url( $item->ID, 'full' ),
              $format == 'video'?( '<div class="video-post"></div>' ):( $format == 'gallery'?( '<div class="gallery-post"></div>' ):( '' ) ),
              printTags( $item->ID )
            );
          }
        ?>

      </div>
      <div class="arrows d-flex justify-content-between"> </div>
    </div>
    <!-- /col-8 -->

    <!-- Sidebar Column -->
    <div class="col-12 sidebar-list">
      <div id="" class="sidebar position-sticky">
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
