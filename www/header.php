<?php
  session_start();
  if( !isset( $_SESSION['sprytne'] ) and !isset( $_GET['sprytne'] ) ){
    echo "strona w budowie...";
    exit;
  }
  else{
    $_SESSION['sprytne'] = 1;
  }

  // wykrywanie urządzenia
  include( get_template_directory() . '/php/Mobile_Detect.php' );
  $detect = new Mobile_Detect();
  $devType = '';
  if ( $detect->isMobile() ) {
    if ( $detect->isTablet() ) {
      $devType = 'tablet';
    }
    else{
      $devType = 'mobile';
    }
  }
  else {
    $devType = 'desktop';
  }


?>
<!DOCTYPE html>
<html lang="pl">

<head>
  <META NAME="robots" CONTENT="noindex">
  <META NAME="robots" CONTENT="nofollow">
  <META NAME="robots" CONTENT="noindex,nofollow">

  <meta name="theme-color" content="#e3000f" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Nowy Targ 24 tv</title>

  <!-- Custom styles -->
  <?php
    //wp_enqueue_style( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, string $media = 'all' )
    wp_enqueue_style( 'bootsrap-core-css', get_template_directory_uri() . '/vendor/bootstrap/css/bootstrap.min.css' );
    wp_enqueue_style( 'custom-fonts', get_template_directory_uri() . '/css/fonts.css' );
    wp_enqueue_style( 'slick', 'https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.css' );
    wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
  ?>
  <?php wp_head(); ?>
</head>

<body class='<?php echo $devType; ?>'>

  <!-- Navigation -->

  <section class="head-menu">
    <div class="container">
      <div class="head-items">
        <div class="logo mr-auto">
            <a href="">
              <img src="<?php echo get_template_directory_uri() . "/" ?>images/logo_nowy_targ.svg" onerror="this.onerror=null; this.src='<?php echo get_template_directory_uri() . "/" ?>images/logo_nowy_targ.png'" alt="Logo Nowy Targ 24 tv">
            </a>
          </div>
        <div class="search-bar">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Szukaj w portalu Nowy Targ 24 TV ...">
          </div>
        </div>
        <div class="weather ml-auto">

          <ul>
            <li>
              <img src="<?php echo get_template_directory_uri() . "/" ?>images/cloud.svg" onerror="this.onerror=null; this.src='<?php echo get_template_directory_uri() . "/" ?>images/cloud.png'" alt="Pogoda">
              <a href="">Sprawdź pogodę</a>
            </li>
            <li>
              <img src="<?php echo get_template_directory_uri() . "/" ?>images/cctv.svg" onerror="this.onerror=null; this.src='<?php echo get_template_directory_uri() . "/" ?>images/cloud.png'" alt="Pogoda">
              <a href="">Kamery na żywo</a>
            </li>
          </ul>

        </div>
      </div>
    </div>
  </section>

  <nav class="navbar navbar-expand-xl navbar-dark bg-white sticky-menu">
    <div class="container">

      <div class="logo mr-auto no-mobile">
        <img src="<?php echo get_template_directory_uri() . "/" ?>images/logo_nowy_targ.svg" onerror="this.onerror=null; this.src='<?php echo get_template_directory_uri() . "/" ?>images/logo_nowy_targ.png'" alt="Logo Nowy Targ 24 tv">
      </div>
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
            <li class="nav-item active">
                <a class="nav-link red-link" href="index.php">Home
                </a>
              </li>
          <li class="nav-item">
            <a class="nav-link red-link" href="kategoria.php">Aktualności
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link red-link" href="#">Taśmy</a>
          </li>
          <li class="nav-item">
            <a class="nav-link red-link" href="#">Sport</a>
          </li>
          <li class="nav-item">
            <a class="nav-link red-link" href="#">Kultura</a>
          </li>
          <li class="nav-item">
            <a class="nav-link red-link" href="#">Przegląd</a>
          </li>
          <li class="nav-item">
            <a class="nav-link red-link" href="#">Reportaże</a>
          </li>
          <li class="nav-item">
            <a class="nav-link red-link" href="#">Będzie się działo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link red-link" href="#">Na żywo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link red-link" href="#">Tablice</a>
          </li>
          <li class="nav-item">
            <a class="nav-link red-link" href="#">Odeszli</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="clear-top"></div>
