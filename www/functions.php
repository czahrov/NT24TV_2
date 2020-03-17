<?php
  date_default_timezone_set('Europe/Warsaw');

  add_theme_support('post-formats', array( 'gallery', 'video' ));
  add_theme_support('post-thumbnails');
  register_nav_menus(array(
    'main' => 'Menu główne, wyświetlane na górze strony',
  ));

  /* generuje komunikat o transmisji live */
  add_action( 'get_live', function( $arg ){

    /* tablica przechowująca wszystkie transmisje live, które mogą być wyświetlane */
    $lives = get_posts( array(
      'numberposts' => 1,
      'order' => 'DESC',
      'orderby' => 'date',
      'category_name' => 'transmisja-live',
      'meta_key' => 'visibility',
      'meta_value' => 'true',

    ) );

    if( empty( $lives ) ){

      $auto = get_posts( array(
        'category_name' => 'transmisja-live',
        'meta_key' => 'visibility',
        'meta_value' => 'auto',

      ) );

      foreach( $auto as $item ){
        $meta = get_post_meta( $item->ID );

        // 01/06/2020-12:00
        $start = $meta[ 'start' ][0];
        sscanf( $start, "%u/%u/%u-%u:%u", $start_day, $start_month, $start_year, $start_hour, $start_minute );
        $t = new DateTime( sprintf( "%u-%u-%u %u:%u:00",
        $start_year,
        $start_month,
        $start_day,
        $start_hour,
        $start_minute

        ) );
        $start_time = $t->getTimestamp();

        // 01/06/2020-12:00
        $end = $meta[ 'end' ][0];
        sscanf( $end, "%u/%u/%u-%u:%u", $end_day, $end_month, $end_year, $end_hour, $end_minute );
        $t = new DateTime( sprintf( "%u-%u-%u %u:%u:00",
        $end_year,
        $end_month,
        $end_day,
        $end_hour,
        $end_minute

        ) );
        $end_time = $t->getTimestamp();

        // 2013-03-15 23:40:00
        $t = new DateTime();
        $now = $t->getTimestamp();

        if( $start_time <= $now && $now < $end_time ){
          $lives[] = $item;
          break;

        }

      }

    }

    if( !empty( $lives ) ){
      $item = $lives[0];

      $meta = get_post_meta( $item->ID );

      switch( $meta[ 'header_type' ][0] ){
        case "text":
        printf(
        "<div id='live' class='text bg-grey-light'>
          <div class='container'>
            <div class='row'>
              <div class='box fc-white bg-red fw-semibold d-flex align-items-center justify-content-center col-md-3 col-xl-2'>
                transmisja na żywo:
              </div>
              <div class='col-12 col-md align-self-center info d-flex flex-column justify-content-center'>
                <div class='header fw-bold'>%s</div>
                <div class='subheader fw-semibold'>%s</div>

              </div>
              <a class='col-12 col-md col-lg-3 align-self-center btn bg-red fc-white' href='%s' target='_blank'>
                <span class='icon fa fa-play-circle-o'></span>
                oglądaj na żywo

              </a>

            </div>

          </div>

        </div>",
        $meta[ 'header' ][0],
        $meta[ 'subheader' ][0],
        $meta[ 'www' ][0]
        );

        break;
        case "img":
        printf(
        "<div id='live' class='img'>
          <div class='container'>
            <div class='row'>
              <div class='box col-md-3 col-xl-2 d-flex align-items-center justify-content-center'>
                transmisja na żywo:
              </div>
              <a class='col banner' href='%s' target='_blank' style='background-image: url(%s); min-height: 130px; !important'></a>

            </div>

          </div>

        </div>",
        $meta[ 'www' ][0],
        wp_get_attachment_image_url( $meta[ 'img' ][0], 'full' )
        );

        break;

      }

    }

    // $meta = get_post_meta( $posts[0]->ID );

    // print_r( $posts );
    // print_r( $meta );

    // print_r( $lives );

  } );

  /* generuje komunikat o transmisji live 2 wersja */
  add_action( 'get_live_event', function( $arg ){

    /* tablica przechowująca wszystkie transmisje live, które mogą być wyświetlane */
    $lives = get_posts( array(
    'numberposts' => 1,
    'order' => 'DESC',
    'orderby' => 'date',
    'category_name' => 'transmisja-live-event',
    'meta_key' => 'visibility',
    'meta_value' => 'true',

    ) );

    if( empty( $lives ) ){

      $auto = get_posts( array(
      'category_name' => 'transmisja-live-event',
      'meta_key' => 'visibility',
      'meta_value' => 'auto',

      ) );

      foreach( $auto as $item ){
        $meta = get_post_meta( $item->ID );

        // 01/06/2020-12:00
        $start = $meta[ 'start' ][0];
        sscanf( $start, "%u/%u/%u-%u:%u", $start_day, $start_month, $start_year, $start_hour, $start_minute );
        $t = new DateTime( sprintf( "%u-%u-%u %u:%u:00",
        $start_year,
        $start_month,
        $start_day,
        $start_hour,
        $start_minute

        ) );
        $start_time = $t->getTimestamp();

        // 01/06/2020-12:00
        $end = $meta[ 'end' ][0];
        sscanf( $end, "%u/%u/%u-%u:%u", $end_day, $end_month, $end_year, $end_hour, $end_minute );
        $t = new DateTime( sprintf( "%u-%u-%u %u:%u:00",
        $end_year,
        $end_month,
        $end_day,
        $end_hour,
        $end_minute

        ) );
        $end_time = $t->getTimestamp();

        // 2013-03-15 23:40:00
        $t = new DateTime();
        $now = $t->getTimestamp();

        if( $start_time <= $now && $now < $end_time ){
          $lives[] = $item;
          break;

        }

      }

    }

    if( !empty( $lives ) ){
      $item = $lives[0];

      $meta = get_post_meta( $item->ID );

      switch( $meta[ 'header_type' ][0] ){
        case "text":
        printf(
        "<div id='live' class='text'>

          <div class='row'>

            <div class='col-12 col-md align-self-center info d-flex flex-column justify-content-center'>
              <div class='header'>%s</div>
              <div class='subheader'>%s</div>

            </div>
            <a class='col-12 col-md col-lg-3 align-self-center btn' href='%s' target='_blank'>
              <span class='icon fa fa-play-circle-o'></span>
              oglądaj na żywo

            </a>

          </div>


        </div>",
        $meta[ 'header' ][0],
        $meta[ 'subheader' ][0],
        $meta[ 'www' ][0]
        );

        break;
        case "img":
        printf(
        "<div id='live' style='height: 230px; overflow:hidden;' class='img'>

          <div class='row'>

            <a class='col banner' href='%s' target='_blank' style='background-image: url(%s); background-repeat:no-repeat;height:230px;     background-size: contain;'></a>

          </div>



        </div>",
        $meta[ 'www' ][0],
        wp_get_attachment_image_url( $meta[ 'img' ][0], 'full' )
        );

        break;

      }

    }

    // $meta = get_post_meta( $posts[0]->ID );

    // print_r( $posts );
    // print_r( $meta );

    // print_r( $lives );

  } );

  /* generuje komunikat o relacji live */
  add_action( 'get_relacja-live-event', function( $arg ){

    /* tablica przechowująca wszystkie transmisje live, które mogą być wyświetlane */
    $lives = get_posts( array(
    'numberposts' => 1,
    'order' => 'DESC',
    'orderby' => 'date',
    'category_name' => 'relacja-live-event',
    'meta_key' => 'visibility',
    'meta_value' => 'true',

    ) );

    if( empty( $lives ) ){

      $auto = get_posts( array(
      'category_name' => 'relacja-live-event',
      'meta_key' => 'visibility',
      'meta_value' => 'auto',

      ) );

      foreach( $auto as $item ){
        $meta = get_post_meta( $item->ID );

        // 01/06/2020-12:00
        $start = $meta[ 'start' ][0];
        sscanf( $start, "%u/%u/%u-%u:%u", $start_day, $start_month, $start_year, $start_hour, $start_minute );
        $t = new DateTime( sprintf( "%u-%u-%u %u:%u:00",
        $start_year,
        $start_month,
        $start_day,
        $start_hour,
        $start_minute

        ) );
        $start_time = $t->getTimestamp();

        // 01/06/2020-12:00
        $end = $meta[ 'end' ][0];
        sscanf( $end, "%u/%u/%u-%u:%u", $end_day, $end_month, $end_year, $end_hour, $end_minute );
        $t = new DateTime( sprintf( "%u-%u-%u %u:%u:00",
        $end_year,
        $end_month,
        $end_day,
        $end_hour,
        $end_minute

        ) );
        $end_time = $t->getTimestamp();

        // 2013-03-15 23:40:00
        $t = new DateTime();
        $now = $t->getTimestamp();

        if( $start_time <= $now && $now < $end_time ){
          $lives[] = $item;
          break;

        }

      }

    }

    if( !empty( $lives ) ){
      $item = $lives[0];

      $meta = get_post_meta( $item->ID );

      switch( $meta[ 'header_type' ][0] ){
        case "text":
        printf(
        "<div id='live' class='text'>

          <div class='row'>

            <div class='col-12 col-md align-self-center info d-flex flex-column justify-content-center'>
              <div class='header'>%s</div>
              <div class='subheader'>%s</div>

            </div>
            <a class='col-12 col-md col-lg-3 align-self-center btn' href='%s' target='_blank'>
              <span class='icon fa fa-play-circle-o'></span>
              oglądaj na żywo

            </a>

          </div>


        </div>",
        $meta[ 'header' ][0],
        $meta[ 'subheader' ][0],
        $meta[ 'www' ][0]
        );

        break;
        case "img":
        printf(
        "<div id='live' style='height:190px; overflow:hidden;' class='img'>

          <div class='row'>

            <a class='col banner' href='%s' target='_blank' style='background-image: url(%s); background-repeat:no-repeat;height:190px; !important'></a>

          </div>



        </div>",
        $meta[ 'www' ][0],
        wp_get_attachment_image_url( $meta[ 'img' ][0], 'full' )
        );

        break;

      }

    }

    // $meta = get_post_meta( $posts[0]->ID );

    // print_r( $posts );
    // print_r( $meta );

    // print_r( $lives );

  } );

  function printImportant( $id = null, $icon = false ){
    if( get_post_meta( $id, 'pilne', true ) == 1 ){
      if ( $icon ) {
        return sprintf(
          '<img class="tag-icon" src="%s/images/important.svg"/ alt="Ważne" title="Ważna informacja">',
          get_template_directory_uri()
        );
      }
      else{
        return '<div class="item">Pilne</div>';
      }
    }
  }

  function printFresh( $id = null, $icon = false ){
    $timeNow = date_create()->getTimestamp();
    $timePost = date_create( get_the_date( 'Y-m-d H:i:s', $id ) )->getTimestamp();
    $timeLimit = 1 * 60 * 60;

    if( $timeNow - $timePost <= $timeLimit ){
      if ( $icon ) {
        return sprintf(
          '<img class="tag-icon" src="%s/images/new.svg"/ alt="Nowość" title="Przed chwilą">',
          get_template_directory_uri()
        );
      }
      else{
        return '<div class="item">Przed chwilą</div>';
      }
    }
  }

  function printHot( $id = null, $icon = false ){
    if ( get_comments_number( $id ) >= 5 ) {
      if ( $icon ) {
        return sprintf(
          '<img class="tag-icon" src="%s/images/hot.svg"/ alt="Trwa dyskusja" title="Gorący temat">',
          get_template_directory_uri()
        );
      }
      else {
        return '<div class="item">Trwa dyskusja</div>';
      }
    }
  }

  function printTags( $id = null, $icon = true ){
    return sprintf(
      '%s %s %s',
      printFresh( $id, $icon ),
      printImportant( $id, $icon ),
      printHot( $id, $icon )
    );
  }

  function printAd( $type = null, $promo = false ){
    if ( $type == null ) return false;
    static $loaded = array();

    $std_meta_query = array(
      array(
        'key'     => 'uklad',
        'value'   => $type,
      ),
    );

    $promo_meta_query = array(
      'relation'    => 'AND',
      array(
        'key'     => 'uklad',
        'value'   => $type,
      ),
      array(
        'key'     => 'sponsorowany',
        'value'   => 'promo',
      ),
    );

    $found = get_posts(array(
      'numberposts'     => 1,
      'category_name'   => 'banner-reklamowy',
      'exclude'         => $loaded,
      'meta_query'      => $promo?( $promo_meta_query ):( $std_meta_query ),
      'orderby'         => 'rand',
    ));

    if ( empty( $found ) ) return false;

    $ad = $found[0];
    $loaded[] = $ad->ID;
    $typ = get_post_field( 'typ', $ad->ID );
    $href = get_post_field( 'href', $ad->ID );
    $target = get_post_field( 'target', $ad->ID );

    if ( $typ == 'uri' ) {
      $img = get_post_field( 'uri', $ad->ID );
    }
    elseif( $typ == 'local' ) {
      $imgID = get_post_field( 'obraz', $ad->ID );
      $img = wp_get_attachment_image_url( $imgID, 'full' );
    }
    else{
      return false;
    }

    printf(
      '<a class="adbox" href="%s" target="%s">
        <img src="%s"/>
      </a>',
      $href,
      $target,
      $img
    );

  }

  function printGallery( $shortcode = null ){
    static $num = 1;
    $ret = "<div id='fpGallery_{$num}' style='display:none'>";

    preg_match( '/ids="([\d,]+)"/', $shortcode, $found );
    $ids = explode( ',', $found[1] );

    foreach ($ids as $media_id) {
      $img_thumb = wp_get_attachment_image_url( $media_id, 'thumbnail' );
      $img_full = wp_get_attachment_image_url( $media_id, 'full' );

      $ret .= sprintf(
        '<img alt="%1$s"
        src="%2$s"
				data-image="%3$s"
				data-description="%1$s">',
        get_the_title( $media_id ),
        $img_thumb,
        $img_full
      );
    }

    $ret .= "</div>";
    return $ret;
  }

?>
