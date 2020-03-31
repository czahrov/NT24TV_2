<?php
  $category = get_category_by_slug('przeglad-tygodniowy');
  $items = get_posts(array(
    'numberposts'   => 13,
    'cat'           => $category->term_id,
  ));
?>
<!-- Page Content -->
<div id='przeglad_tygodniowy' class="<?php echo getDevType(); ?> container">
  <div class="row no-gutters">
<!-- Blog Entries Column -->
    <div class="col-12">
      <h5 class="title-sidebar">Przegląd tygodniowy</h5>
      <!-- BIG Post -->
      <?php
        $item = $items[0];
        $format = get_post_format( $item );

        printf(
          '<a class="link_post big" href="%4$s">
            <div class="big-post">
              <div class="cover_img"></div>
              <div class="post_news_big  img12" style="background-image:url(%1$s)">
                %3$s
                <span>%5$s %2$s</span>
              </div>
            </div>
          </a>',
          get_the_post_thumbnail_url( $item->ID, 'full' ),
          $item->post_title,
          $format == 'video'?('<div class="video-post"></div>'):( $format == 'gallery'?('<div class="gallery-post"></div>'):('') ),
          get_permalink( $item->ID ),
          printTags( $item->ID, false )
        );
      ?>

      <div class="clear-top"></div>

      <div class="mid_post row no-gutters">

        <!-- MID post -->
        <?php
          foreach ( array_slice( $items, 1 ) as $item ) {
            $format = get_post_format( $item );
            printf(
              '<div class="item col-6 col-md-4">
                <a href="%1$s" class="link_post_small">
                  <div class="small-post">
                    <div class="post_news_small">
                      %3$s
                      <div class="cover_img img13" style="background-image:url(%2$s)"></div>
                    </div>
                    <span>%5$s %4$s</span>
                  </div>
                </a>
              </div>',
              get_permalink( $item->ID ),
              get_the_post_thumbnail_url( $item->ID, 'large' ),
              $format == 'video'?( '<div class="video-post"></div>' ):( $format == 'gallery'?( '<div class="gallery-post"></div>' ):( '' ) ),
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

      <!-- reklama pozioma -->
      <?php echo printAd('h-m'); ?>
      <!-- <div class="reklama-full-page">
        <div class="reklama">Reklama 840x150px</div>
      </div> -->

    </div>
    <!-- /col-8 -->
<!-- Sidebar Column -->
    <div id="" class="sidebar col-12 sidebar-list">
      <h5 class="title-sidebar">Stan powietrza Nowy Targ</h5>

      <?php get_template_part('template/airly'); ?>

      <div class="reportaze sticky">
        <div class="clear-top"></div>
        <h5 class="title-sidebar line">Reportaże</h5>
        <?php
          $items = get_posts(array(
            'numberposts'     => 8,
            'category_name'   => 'reportaze',
          ));
        ?>
        <ul class="image-sidebar-section row no-gutters">

          <!-- single post -->
          <?php
            foreach ( $items as $item ) {
              $format = get_post_format( $item );
              printf(
                '<a class="col-12 col-sm-6" href="%1$s">
                  <li>
                    <div class="image-container">
                      <div class="image img5" style="background-image:url(%2$s)">
                      %4$s
                      </div>
                    </div>
                    <span>%5$s %3$s</span>
                  </li>
                </a>',
                get_permalink( $item->ID ),
                get_the_post_thumbnail_url( $item->ID, 'medium' ),
                $item->post_title,
                $format == 'video'?( '<div class="video-post"></div>' ):( $format == 'gallery'?( '<div class="gallery-post"></div>' ):( '' ) ),
                printTags( $item->ID )
              );
            }
          ?>

        </ul>

      </div>
      <!-- /reportaże -->

    </div>
  </div>
  <!-- /.row -->

</div>
<!-- /.container -->
<div class="clear-top"></div>