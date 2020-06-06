<!-- Page Content -->
<div id='wskrocie' class="<?php echo getDevType(); ?> container padding">
  <div class="row no-gutters">
    <div class="col-12 col-md-8">
      <?php $category_bedzie_sie_dzialo = get_category( 62 ); ?>
      <a href="<?php echo get_category_link( $category_bedzie_sie_dzialo->cat_ID ); ?>">
        <h5 class="title-sidebar"><?php echo $category_bedzie_sie_dzialo->name; ?></h5>
      </a>
      <div class="slider">
        <!-- post -->
        <?php
          $items = get_posts( array(
            'numberposts' => 7,
            'cat'         => $category_bedzie_sie_dzialo->cat_ID,
          ) );
          foreach ($items as $item) {
            printPost( $item, 'slider' );
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
                printPost( $item, 'slider' );
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
      </div>

    </div>
    <!-- /col-8 -->
    <!-- Sidebar Column -->
    <div class="sidebar col col-md-4 sidebar-list">
      <?php get_template_part("template/sidebar-urzedowe-desktop"); ?>
      <div class="clear-top"></div>
      <?php $category_filmy_promocyjne = get_category(113); ?>
      <h5 class="title-sidebar"><?php echo $category_filmy_promocyjne->name; ?></h5>
      <div class="filmy-promocyjne">
        <?php
          $items = get_posts(array(
            'cat'           => $category_filmy_promocyjne->cat_ID,
            'numberposts'   => 2,
          ));

          foreach ($items as $item) {
            printPost( $item, 'side-big' );
          }
        ?>

      </div>

    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
</div>
