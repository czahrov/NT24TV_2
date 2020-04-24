<!-- Page Content -->
<div id='wskrocie' class="<?php echo getDevType(); ?> container">
  <div class="row no-gutters">
    <div class="col-12">
      <a href="<?php echo get_category_link( get_category_by_slug( 'bedzie-sie-dzialo' )->cat_ID ); ?>">
        <h5 class="title-sidebar">Będzie się działo</h5>
      </a>
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
              get_the_post_thumbnail_url( $item->ID, 'medium' ),
              $item->post_title,
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
                  get_the_post_thumbnail_url( $item->ID, 'medium'),
                  $item->post_title,
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
    <div class="sidebar col-12 sidebar-list row no-gutters">
      <div class="reportaze ogloszenia-urzedowe col-12 col-lg-6">
        <a href="<?php echo get_category_link( get_category_by_slug( 'ogloszenia-urzedowe' )->cat_ID ); ?>">
          <h5 class="title-sidebar line">Ogłoszenia urzędowe</h5>
        </a>
        <ul class="image-sidebar-section">
          <?php
            $items = get_posts(array(
              'numberposts'   => 4,
              'category_name' => 'ogloszenia-urzedowe',
            ));
          ?>
          <!-- single post -->
          <?php
            foreach ($items as $item) {
              printf(
                '<a href="%s">
                  <li>
                    <div class="image-container">
                      <div class="image" style="background-image:url(%s);"></div>
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
      <!-- /ogłoszenia urzędowe -->
      <div class="col-12 col-lg-6">
        <h5 class="title-sidebar">Filmy promocyjne</h5>
        <div class="filmy-promocyjne row no-gutters">
        <?php
          $items = get_posts(array(
            'category_name' => 'filmy-promocyjne',
            'numberposts'   => 2,
          ));

          foreach ($items as $item) {
            printf(
              '<a class="single col-12 col-sm-6 col-lg-12 no-padding" href="%s" alt="%s">
                <div class="image-container">
                  <div class="image" style="background-image:url(%s);">
                    <div class="video-post">
                      <img src="%s/images/play.svg" alt="odtwórz film"/>
                    </div>
                  </div>
                </div>
              </a>',
              get_permalink( $item->ID ),
              $item->post_title,
              get_the_post_thumbnail_url( $item->ID, 'medium' ),
              get_template_directory_uri()
            );
          }
        ?>

      </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
</div>
