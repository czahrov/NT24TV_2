<!-- Page Content -->
<div id='wskrocie' class="<?php echo getDevType(); ?> container">

  <div class="row no-gutters">

    <div class="col-md-12 col-lg-8">
      <h5 class="title-sidebar">Będzie się działo</h5>
      <div class="slider">
        <?php
          $items = get_posts( array(
            'numberposts' => 7,
            'category_name' => 'bedzie-sie-dzialo',
          ) );
        ?>
        <!-- post -->
        <?php
          foreach ($items as $item) {
            printf(
              '<div class="slide-content">
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
              get_the_post_thumbnail_url( $item->ID, 'medium' ),
              printTags( $item->ID )
            );
          }
        ?>
      </div>
      <div class="button-line slider-arrows">
        <button class="prev slick-arrow">
          <img src="<?php echo get_template_directory_uri() . "/" ?>images/arrow.svg" onerror="this.onerror=null; this.src='<?php echo get_template_directory_uri() . "/" ?>images/arrow.png'" alt="strzałka">
        </button>
        <button class="next slick-arrow">
          <img src="<?php echo get_template_directory_uri() . "/" ?>images/arrow.svg" onerror="this.onerror=null; this.src='<?php echo get_template_directory_uri() . "/" ?>images/arrow.png'" alt="strzałka">
        </button>

      </div>

      <div class="clear-top"></div>
      <div class="row no-gutters">
        <div class="col-md-12">
          <h5 class="title-sidebar">Najnowsze video</h5>
          <?php
            $items = get_posts(array(
              'numberposts' => 7,
              'tax_query' => array(
        				array(
        					'taxonomy' => 'post_format',
        					'field' => 'slug',
        					'terms' => array( 'post-format-video' ),
        				),
        			),
            ));
          ?>
          <div class="slider">
            <!-- post -->
            <?php
              foreach ($items as $item) {
                printf(
                  '<div class="slide-content">
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
                  get_the_post_thumbnail_url( $item->ID, 'medium'),
                  printTags( $item->ID )
                );
              }
            ?>

          </div>
          <div class="button-line slider-arrows">
            <button class="prev slick-arrow">
              <img src="<?php echo get_template_directory_uri() . "/" ?>images/arrow.svg" onerror="this.onerror=null; this.src='<?php echo get_template_directory_uri() . "/" ?>images/arrow.png'" alt="strzałka">
            </button>
            <button class="next slick-arrow">
              <img src="<?php echo get_template_directory_uri() . "/" ?>images/arrow.svg" onerror="this.onerror=null; this.src='<?php echo get_template_directory_uri() . "/" ?>images/arrow.png'" alt="strzałka">
            </button>

          </div>

        </div>

      </div>
      <div class="">
        <!-- reklama pozioma -->
        <?php echo printAd( 'h-m' ); ?>
        <!-- <div class="reklama-full-page sticky">
        <div class="reklama">Reklama 840x150px</div>
      </div> -->
      </div>

    </div>
    <!-- /col-8 -->

    <!-- Sidebar Column -->
    <div class="sidebar col-lg-4 col-md-12 sidebar-list">
      <?php get_template_part("template/sidebar-urzedowe-desktop"); ?>
      <div class="clear-top"></div>
      <h5 class="title-sidebar">Filmy promocyjne</h5>
      <div class="filmy-promocyjne">
        <?php
          $items = get_posts(array(
            'category_name' => 'filmy-promocyjne',
            'numberposts'   => 2,
          ));

          foreach ($items as $item) {
            printf(
              '<a href="%1$s" class="single" title="%5$s">
                <div class="image-container">
                  <div class="image vid1" style="background-image:url(%2$s);">
                    <div class="video-post">
                      <img src="%4$s/images/play.svg" alt="odtwórz film"/>
                    </div>
                    <div class="post-tags">
                      %3$s
                    </div>
                  </div>
                </div>
              </a>',
              get_permalink( $item->ID ),
              get_the_post_thumbnail_url( $item->ID, 'medium' ),
              printTags( $item->ID, false ),
              get_template_directory_uri(),
              $item->post_title
            );
          }
        ?>

      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->
</div>
