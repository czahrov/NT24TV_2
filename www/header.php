<?php
  // session_start();

  // blokada dostępu
  if( !isset( $_COOKIE['sprytne'] ) and !isset( $_GET['sprytne'] ) ){
    echo "strona w budowie...";
    exit;
  }
  else{
    setcookie( 'sprytne', 1, 0, '/' );
  }

  // Facepalm
  global $fp;
  $fp = new Facepalm();
?>
<!DOCTYPE html>
<html lang="pl">
  <head>
  <!-- <META NAME="robots" CONTENT="noindex">
  <META NAME="robots" CONTENT="nofollow">
  <META NAME="robots" CONTENT="noindex,nofollow"> -->

  <meta name="theme-color" content="#e3000f" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo bloginfo('description'); ?>">
  <meta name="author" content="">
  <title><?php wp_title( '|', true, 'right' ); echo bloginfo('name'); ?></title>
  <link rel="preconnect" href="https://via.placeholder.com/">

  <?php
    // wp_enqueue_style( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, string $media = 'all' )
    // wp_enqueue_script( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, bool $in_footer = false )


    // jQuery
    wp_enqueue_script( 'jQuery', get_template_directory_uri().'/vendor/jquery/jquery.min.js', array(), false, true );

    // GSAP
    wp_enqueue_script( 'GSAP-TMAX', get_template_directory_uri().'/js/TweenMax.min.js', array( 'jQuery' ), false, true );

    // bootstrap
    wp_enqueue_style( 'bootsrap-core-css', get_template_directory_uri() . '/vendor/bootstrap/css/bootstrap.min.css' );
    wp_enqueue_script( 'bootsrap', get_template_directory_uri().'/vendor/bootstrap/js/bootstrap.bundle.min.js', array( 'jQuery' ), false, true );

    // slick slider
    wp_enqueue_style( 'slickTheme', get_template_directory_uri() . '/css/slick-theme.css', array() );
    wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css', array('slickTheme') );
    wp_enqueue_script( 'slickJS', get_template_directory_uri().'/js/slick.min.js', array(), false, true );

    // unitegallery
    wp_enqueue_style( 'UGalleryCSS', get_template_directory_uri() . '/css/unite-gallery.css' );
    wp_enqueue_script( 'UGalleryJS', get_template_directory_uri().'/js/unitegallery.min.js', array( 'jQuery' ), false, true );
    wp_enqueue_script( 'UGalleryThemeJS', get_template_directory_uri().'/ug_themes/tiles/ug-theme-tiles.js', array( 'UGalleryJS' ), false, true );
    // wp_enqueue_script( 'UGalleryThemeJS', get_template_directory_uri().'/ug_themes/compact/ug-theme-compact.js', array(), false, true );

    // custom
    wp_enqueue_style( 'custom-fonts', get_template_directory_uri() . '/css/fonts.css' );
    wp_enqueue_style( 'style', get_template_directory_uri() . '/css/main.css' );
    wp_enqueue_style( 'fp_style', get_template_directory_uri() . '/css/facepalm.css', array( 'style' ) );
    wp_enqueue_script( 'home_slick', get_template_directory_uri().'/js/home_slick.js', array( 'slickJS' ), false, true );
    wp_enqueue_script( 'facepalm', get_template_directory_uri().'/js/facepalm.js', array( 'jQuery' ), false, true );
  ?>

  <?php wp_head(); ?>
</head>

<body class='<?php echo getDevType(); ?>'>
  <?php do_action( 'get_live' ); ?>
  <?php do_action( 'get_live_event' ); ?>
  <?php do_action( 'get_relacja-live-event' ); ?>

  <!-- Navigation -->
  <section class="head-menu">
    <div class="container">
      <div class="head-items">
        <div class="logo mr-auto">
            <a href="<?php echo get_option('siteurl') ?>">
              <img src="<?php echo get_template_directory_uri() . "/" ?>images/logo_nowy_targ.svg" onerror="this.onerror=null; this.src='<?php echo get_template_directory_uri() . "/" ?>images/logo_nowy_targ.png'" alt="Logo Nowy Targ 24 tv">
            </a>
          </div>
        <form class="search-bar" method="get" action="<?php echo home_url('szukaj'); ?>">
          <div class="input-group">
            <input class="form-control" type="text" name="q" pattern="(?=.*\S).{3,}" title="Szukana fraza musi składać się z co najmniej 4 znaków alfanumerycznych" placeholder="Szukaj w portalu Nowy Targ 24 TV ..." required>
          </div>
        </form>
        <div class="weather ml-auto">
          <ul>
            <li>
              <img src="<?php echo get_template_directory_uri() . "/images/cloud.svg" ?>" alt="Pogoda">
              <a href="<?php echo home_url('pogoda'); ?>">Sprawdź pogodę</a>
            </li>
            <li>
              <img src="<?php echo get_template_directory_uri() . "/images/cctv.svg" ?>"alt="Pogoda">
              <a href="<?php echo home_url('kamery'); ?>">Kamery na żywo</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <nav class="navbar navbar-expand-xl navbar-dark bg-white sticky-menu">
    <div class="container">

      <a href="<?php echo home_url(); ?>" class="logo mr-auto no-mobile">
        <img src="<?php echo get_template_directory_uri() . "/" ?>images/logo_nowy_targ.svg" onerror="this.onerror=null; this.src='<?php echo get_template_directory_uri() . "/" ?>images/logo_nowy_targ.png'" alt="Logo Nowy Targ 24 tv">
      </a>
      <span class="toggler-name no-mobile">MENU</span>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
        aria-expanded="false" aria-label="Toggle navigation">
        <!-- <span class="navbar-toggler-icon"></span> -->
        <span class="circle"></span>
        <span class="circle"></span>
        <span class="circle"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav mr-auto">
            <?php
              $post = get_post();
              foreach ( wp_get_nav_menu_items('glowne-menu') as $item ){
                printf(
                  '<li class="nav-item %3$s %4$s">
                    <a class="nav-link red-link" href="%1$s">
                      %2$s
                    </a>
                  </li>',
                  $item->url,
                  $item->title,
                  $item->guid == $post->guid?( 'active' ):( '' ),
                  implode( ' ', $item->classes )
                );
              }
            ?>
          </ul>
        </div>
    </div>
  </nav>
  <div class="clear-top"></div>
  <?php if ( getDevType() !== 'desktop'): ?>
    <div id="bot-bar" class="d-flex justify-content-around">
      <a class="button camera d-flex align-items-center justify-content-center" href="<?php echo home_url('kamery'); ?>">
        <div class="box"> </div>
        <img src="<?php echo get_template_directory_uri() . "/images/cctv.svg"; ?>" alt="Kamery live">
      </a>
      <div class="button search d-flex align-items-center justify-content-center">
        <div class="box"> </div>
        <img src="<?php echo get_template_directory_uri() . "/images/magnifying_glass.svg"; ?>" alt="wyszukiwarka">
      </div>
      <a class="button forecast d-flex align-items-center justify-content-center" href="<?php echo home_url('pogoda'); ?>">
        <div class="box"> </div>
        <img src="<?php echo get_template_directory_uri() . "/images/cloud.svg"; ?>" alt="prognoza pogody">
      </a>
    </div>
    <div id="search-popup" class="">
      <div class="box"> </div>
    </div>
  <?php endif; ?>
