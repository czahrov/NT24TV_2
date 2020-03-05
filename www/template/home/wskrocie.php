<!-- Page Content -->
<div class="container">

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
                    <span>%2$s</span>
                  </div>
                </a>
              </div>',
              get_permalink( $item->ID ),
              $item->post_title,
              get_the_post_thumbnail_url( $item->ID, 'medium' )
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
          <div class="">
            <!-- <?php print_r( $items ); ?> -->
          </div>
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
                        <span>%2$s</span>
                      </div>
                    </a>
                  </div>',
                  get_permalink( $item->ID ),
                  $item->post_title,
                  get_the_post_thumbnail_url( $item->ID, 'medium')
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
      <div class="reklama-full-page sticky">
        <div class="reklama">Reklama 840x150px</div>
      </div>

    </div>
    <!-- /col-8 -->

    <!-- Sidebar Column -->
    <div class="col-lg-4 col-md-12 sidebar-list">
      <div class="reportaze ogloszenia-urzedowe">
        <h5 class="title-sidebar line">Ogłoszenia urzędowe</h5>

        <ul class="image-sidebar-section">

          <!-- single post -->
          <a href="#">
            <li>
              <div class="image-container">
                <div class="image img19"></div>
              </div>
              <span>Od 1 lutego - obowiązek segregacji odpadów. Jak robić to prawidłowo? </span>
            </li>
          </a>

          <!-- single post -->
          <a href="#">
            <li>
              <div class="image-container">
                <div class="image img20">
                </div>
              </div>
              <span>Harmonogram odbioru odpadów komunalnych z nieruchomości...y</span>
            </li>
          </a>

          <!-- single post -->
          <a href="#">
            <li>
              <div class="image-container">
                <div class="image img21"></div>
              </div>
              <span>Zimowe utrzymanie dróg na terenie Nowego Targu</span>
            </li>
          </a>



          <!-- single post -->
          <a href="#">
            <li>
              <div class="image-container">
                <div class="image img23"></div>
              </div>
              <span>Koncert Noworoczny aż zapierał dech…
              </span>
            </li>
          </a>


        </ul>



      </div>
      <!-- /ogłoszenia urzędowe -->
      <div class="clear-top"></div>
      <h5 class="title-sidebar">Filmy promocyjne</h5>

      <div class="filmy-promocyjne">

        <a href="" class="single">
          <div class="image-container">
            <div class="image vid1">
              <div class="video-icon"></div>
            </div>
          </div>
        </a>

        <a href="" class="single">
          <div class="image-container">
            <div class="image vid2">
              <div class="video-icon"></div>
            </div>
          </div>
        </a>

      </div>



    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->
</div>
