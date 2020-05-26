<?php
  /*Template Name: Strona główna*/
?>
<?php
  get_header();
  the_post();
  wp_enqueue_style( 'page-tablice', get_template_directory_uri().'/css/page-tablice.css' );
  // $thumb = get_the_post_thumbnail_url( get_the_ID(), 'full' );
  // $bgimg = !$thumb?( get_template_directory_uri() . "/images/page.jpg" ):( $thumb );
?>
<div id="tablice" class="">
  <div class="container">
    <div class="row no-gutters">
      <div class="content padding col-12 col-lg-8">
        <div class="tablice-kontentowo">
          <div class="row tytul-kontakt">
            <div class="tablice-header d-flex flex-wrap">
              <div class=" mr-auto tablice-claim">
                <h1>
                  <p>
                    <?php echo get_field('tablice-tytul'); ?>
                  </p>
                </h1>
              </div>
              <div class="ml-auto tablice-kontakt">
                <span>Zadzwoń lub napisz</span>
                <p>
                  <?php echo get_field('tablice-kontakt'); ?>
                </p>
              </div>
            </div>
          </div>
          <div class="row content-page">
            <div class="col-xl-12 section_title">
              <h1>O nas</h1>
              <div class="tablice-kontent">
                <?php the_content(); ?>
              </div>
            </div>
          </div>
          <div class="row alert-gora">
            <div class="col-xl-12 tablice-alert">
              <?php echo get_field('tablica-alert-gora') ?>
            </div>
          </div>
          <div class="row zasieg">
            <div class="col-xl-12 section_title">
              <h1>Zasięg</h1>
              <div class="tablice-kontent">
                <img src="<?php echo get_template_directory_uri(); ?>/images/mapa_zasieg.jpg" alt="Lokalizacja tablic. Zrzut ekranu z www.google.com" title="Lokalizacja tablic. Zrzut ekranu z www.google.com">
              </div>
            </div>
          </div>
          <div class="row wykaz-title">
            <div class="col-xl-12 section_title">
              <h1>Wykaz tablic ogłoszeniowych</h1>
            </div>
          </div>
          <div class="row wykaz-tablic">
            <div class="col-xl-6 section_title">
              <div class="tablice-kontent">
                <p>
                  <?php echo get_field('tablice-wykaz-tablic-lewa') ?>
                </p>
              </div>
            </div>
            <div class="col-xl-6 section_title">
              <div class="tablice-kontent">
                <p>
                  <?php echo get_field('tablice-wykaz-tablic-prawa') ?>
                </p>
              </div>
            </div>
          </div>
          <div class="row cennik-title">
            <div class="col-xl-12 section_title" id="cennik">
              <h1>Cennik</h1>
            </div>
          </div>
          <div class="row cennik">
            <div class="col-xl-6 section_title tablice-tabela">
              <p>
                <?php echo get_field('tablice-cennik-lewa'); ?>
              </p>
            </div>
            <div class="col-xl-6 section_title tablice-tabela" id="cennik">
              <p>
                <?php echo get_field('tablice-cennik-lewa'); ?>
              </p>
            </div>
          </div>
          <div class="row alert-dol">
            <div class="col-xl-12 tablice-alert">
              <p>
                <?php echo get_field('tablice-alert-dol'); ?>
              </p>
            </div>
          </div>
          <div class="row" id="regulamin">
            <div class="col-xl-12 tablice-regulamin section_title">
              <p>
                <?php echo get_field('tablice-regulamin'); ?>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="sidebar col-12 col-lg-4 row no-gutters padding-lg d-lg-block">
        <div class="col-12 col-sm col-lg-12">
          <?php echo printAd('v-l'); ?>
        </div>
        <div class="position-sticky col-12 col-sm-7 col-md-8 col-lg-12">
          <?php get_template_part('template/sidebar-nadchodzace-desktop'); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
