<?php
  // session_start();

  // blokada dostępu
  if( isset( $_COOKIE['sprytne'] ) or isset( $_GET['sprytne'] ) ){
    setcookie( 'sprytne', 1, 0, '/' );
    define( 'DBG', true );
  }
  else{
    define( 'DBG', false );
    // include('wbudowie.html');
    // exit;
  }

  // Facepalm
  global $fp;
  $fp = new Facepalm();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta name="theme-color" content="#e3000f" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo bloginfo('description'); ?>">
  <meta name="author" content="">
  <link href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
  <title><?php wp_title(); ?></title>
  <link rel="preconnect" href="https://via.placeholder.com/">
  <link rel="preconnect" href="https://s.ytimg.com">
  <link rel="preconnect" href="https://static.doubleclick.net">
  <link rel="preconnect" href="https://googleads.g.doubleclick.net">
  <link rel="preconnect" href="https://yt3.ggpht.com">
  <link rel="preconnect" href="https://i.ytimg.com">
  <link rel="preconnect" href="https://www.gstatic.com">
  <?php
    // wp_enqueue_style( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, string $media = 'all' )

    // wp_enqueue_script( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, bool $in_footer = false )

    $ver = time();
    $ver = 202007031724;

    // fonty
    wp_enqueue_style( 'custom-fonts', get_template_directory_uri() . '/css/fonts.css', array(), $ver );

    // jQuery
    wp_enqueue_script( 'jQuery', get_template_directory_uri().'/vendor/jquery/jquery.min.js', array(), $ver, true );

    // GSAP
    wp_enqueue_script( 'GSAP-TMAX', get_template_directory_uri().'/js/TweenMax.min.js', array( 'jQuery' ), $ver, true );

    // bootstrap
    wp_enqueue_style( 'bootsrap-core-css', get_template_directory_uri() . '/vendor/bootstrap/css/bootstrap.min.css', array(), $ver );
    wp_enqueue_script( 'bootsrap', get_template_directory_uri().'/vendor/bootstrap/js/bootstrap.bundle.min.js', array( 'jQuery' ), $ver, true );

    // slick slider
    wp_enqueue_style( 'slickTheme', get_template_directory_uri() . '/css/slick-theme.css', array(), $ver );
    wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css', array('slickTheme'), $ver );
    wp_enqueue_script( 'slickJS', get_template_directory_uri().'/js/slick.min.js', array(), $ver, true );

    // unitegallery
    wp_enqueue_style( 'UGalleryCSS', get_template_directory_uri() . '/css/unite-gallery.css', array(), $ver );
    wp_enqueue_script( 'UGalleryJS', get_template_directory_uri().'/js/unitegallery.min.js', array( 'jQuery' ), $ver, true );
    wp_enqueue_script( 'UGalleryThemeJS', get_template_directory_uri().'/ug_themes/tiles/ug-theme-tiles.js', array( 'UGalleryJS' ), $ver, true );
    // wp_enqueue_script( 'UGalleryThemeJS', get_template_directory_uri().'/ug_themes/compact/ug-theme-compact.js', array(), $ver, true );

    // custom
    wp_enqueue_style( 'style', get_template_directory_uri() . '/css/main.css', array(), $ver );
    wp_enqueue_style( 'fp_style', get_template_directory_uri() . '/css/facepalm.css', array( 'style' ), $ver );
    wp_enqueue_script( 'home_slick', get_template_directory_uri().'/js/home_slick.js', array( 'slickJS' ), $ver, true );
    wp_enqueue_script( 'facepalm', get_template_directory_uri().'/js/facepalm.js', array( 'jQuery' ), $ver, true );
  ?>

  <?php wp_head(); ?>
</head>

<body class='<?php echo getDevType().' '.getOSType(); ?>'>
  <?php if (DBG): ?>
    <div id="_debug" class="">
      <div class="_server">
        <?php
          print_r( $_SERVER );
        ?>
      </div>
      <div class="_post">
        <?php
          print_r( get_post() );
        ?>
      </div>
      <div class="_post_meta">
        <?php
          print_r( get_post_meta( get_post()->ID ) );
        ?>
      </div>
      <div class="_post_tags">
        <?php
          print_r( wp_get_post_tags( get_post()->ID ) );
        ?>
      </div>
      <div class="_post_categories">
        <?php
          print_r( wp_get_post_categories( get_post()->ID ) );
        ?>
      </div>
      <div class="_category">
        <?php
          print_r( get_category_by_slug( array_slice( explode( "/", $_SERVER['REQUEST_URI'] ), -2, -1 )[0] ) );
        ?>
      </div>
    </div>
  <?php endif; ?>
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
            <input class="hitbox" type="submit" name="" value="">
            <input class="form-control" type="text" name="q" pattern="(?=.*\S).{3,}" title="Szukana fraza musi składać się z co najmniej 4 znaków alfanumerycznych" placeholder="Szukaj w portalu Nowy Targ 24 TV ..." required>
          </div>
        </form>
        <div class="weather ml-auto">
          <ul>
            <li>
              <img src="<?php echo get_template_directory_uri() . "/images/cloud.svg" ?>" alt="Pogoda">
              <a href="<?php echo get_page_link( get_page_by_title('Pogoda') ); ?>">Sprawdź pogodę</a>
            </li>
            <li>
              <img src="<?php echo get_template_directory_uri() . "/images/cctv.svg" ?>"alt="Pogoda">
              <a href="<?php echo get_page_link( get_page_by_title('Kamery') ); ?>">Kamery na żywo</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <div id="main_menu" class="container <?php echo getDevType(); ?>">
    <a href="<?php echo home_url(); ?>" class="logo flex-grow-1 text-center d-xl-none">
      <img src="<?php echo get_template_directory_uri() . "/" ?>images/logo_nowy_targ.svg" onerror="this.onerror=null; this.src='<?php echo get_template_directory_uri() . "/" ?>images/logo_nowy_targ.png'" alt="Logo Nowy Targ 24 tv">
    </a>
    <nav class="padding no-padding-xl">
      <ul class="items view">
        <?php
          $main_menu = wp_get_nav_menu_items('glowne-menu');
          foreach ( $main_menu as $item ){
            switch ( $item->object ) {
              case 'post':
              case 'page':
                $isActive = get_the_permalink( get_the_ID() ) == $item->url;
                break;
              case 'category':
                $isActive = get_category_link( get_category_by_path( sprintf(
                  '%s://%s%s',
                  $_SERVER['HTTPS'] == 'on'?('https'):('http'),
                  $_SERVER['HTTPS_HOST'],
                  $_SERVER['REQUEST_URI']
                ), false )->cat_ID ) == $item->url;
                break;
              case 'tag':
                break;
              default:
                $isActive = false;
                break;
            }

            printf(
              '<li class="item %3$s %4$s">
                <a class="red-link" href="%1$s"> %2$s </a>
              </li>',
              $item->url,
              $item->title,
              $isActive?( 'marker' ):( '' ),
              implode( ' ', $item->classes )
            );
          }
        ?>
      </ul>
      <div class="more">
        <div class="dots"> ··· </div>
        <ul class='items stack'> </ul>
      </div>
    </nav>
  </div>
  <?php
    $homeID = 40;
    $kolor_pasek = get_field( 'kolor_paska', $homeID );
    $kolor_czcionka = get_field( 'kolor_czcionki', $homeID );
  ?>
  <div id='pilne' class="container-fluid fw-bold no-padding" style="background-color:<?php echo $kolor_pasek; ?>; color:<?php echo $kolor_czcionka; ?>">
    <div class="container d-flex no-padding">
      <div class="label d-flex align-items-center">
        PILNE
      </div>
      <div class="items d-flex flex-shrink-0">
        <?php
          foreach ( getPilnePasek() as $post ) {
            printf(
              '<div class="item d-flex text-center align-items-center justify-content-center flex-shrink-0">
                <div class="separator">&diams;</div>
                <a class="" href="%s">%s</a>
              </div>',
              get_permalink( $post->ID ),
              $post->post_title
            );
          }
        ?>
      </div>
    </div>
  </div>
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
  <div id="popup" class="">
    <div class="box">
      <div class="controls">
        <div class="exit">
          <img src="<?php echo get_template_directory_uri(); ?>/images/close.svg" alt="">
        </div>
      </div>
      <div class="view">

      </div>
    </div>
  </div>
