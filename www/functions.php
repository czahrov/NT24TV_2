<?php
  // header( "Cache-Control: max-age=31536000" );
  header( "Cache-Control: private, no-cache, no-store, must-revalidate, max-age=1" );
  header( "Pragma: no-cache", false );
  // date_default_timezone_set('Europe/Warsaw');
  error_reporting( E_ALL & ~E_WARNING & ~E_NOTICE );

  add_theme_support('post-formats', array( 'gallery', 'video' ));
  add_theme_support('post-thumbnails');
  register_nav_menus(array(
    'main' => 'Menu główne, wyświetlane na górze strony',
  ));

  // Facepalm
  include_once( get_template_directory() . '/php/Facepalm.php' );
  global $fp;
  $fp = new Facepalm();

  // modyfikacja standardowej galerii wp
  add_filter( 'the_content', function( $content ){
    global $fp;

    // NOWY EDYTOR
    // podmiana segmentów
    preg_match_all( '~<\!\-\- wp:gallery.*?"ids":\[(.+?)\].*?/wp:gallery \-\->~ms', $content, $found );
    foreach ($found[1] as $k => $v) {
      $content = str_replace( $found[0][$k], $fp->printUGallery( explode( ',', $v ), false ), $content );
    }

    //STARY EDYTOR
    // podmiana segmentów
    preg_match_all( '~\[gallery.*?ids="(.+?)".*?\]~', $content, $found );
    foreach ($found[1] as $k => $v) {
      $content = str_replace( $found[0][$k], $fp->printUGallery( explode( ',', $v ), false ), $content );
    }

    return $content;
  }, 8 );

  // modyfikacja galerii filebird
  add_filter( 'the_content', function( $content ){
    global $fp;

    // NOWY EDYTOR
    // podmiana segmentów
    preg_match_all( '~<\!\-\- wp:filebird/block\-filebird\-gallery.+?/wp:filebird/block\-filebird\-gallery \-\->~ms', $content, $found );
    // var_dump( $found );
    foreach ($found[0] as $k => $v) {
      // var_dump( $v );
      preg_match_all( '~"id":(\d+)~', $v, $ids );
      // var_dump( $ids );
      $content = str_replace( $v, $fp->printUGallery( $ids[1], false ), $content );
    }

    return $content;
  }, 8 );

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

  function printFormat( $id = null, $icon = false, $blackIcon = true ){
    $format = get_post_format( $id );
    // var_dump( array( 'format' => $format, 'blackIcon' => $blackIcon ) );
    if( $format == 'video' ) {
      if ( $icon ) {
        return sprintf(
          '<img class="tag-icon" src="%s/images/play%s.svg"/ alt="Trwa dyskusja" title="Gorący temat">',
          get_template_directory_uri(),
          $blackIcon?('_black'):('')
        );
      }
      else {
        return '<div class="item">Materiał video</div>';
      }

    }
    elseif( $format == 'gallery' ) {
      if ( $icon ) {
        return sprintf(
          '<img class="tag-icon" src="%s/images/images%s.svg"/ alt="Trwa dyskusja" title="Gorący temat">',
          get_template_directory_uri(),
          $blackIcon?('_black'):('')
        );
      }
      else {
        return '<div class="item">Galeria zdjęć</div>';
      }
    }
  }

  function printTags( $id = null, $icon = true, $blackIcon = true ){
    return sprintf(
      '%s %s %s %s',
      printFormat( $id, $icon, $blackIcon ),
      printFresh( $id, $icon ),
      printImportant( $id, $icon ),
      printHot( $id, $icon )
    );
  }

  function printAd( $type = null, $promo = false ){
    // v-s : Pionowy S ( max 400x230 px )
    // v-m : Pionowy M ( max 400x500 px )
    // v-l : Pionowy L ( max 400x700 px )
    // h-s : Poziomy S ( max 400 px szerokości )
    // h-m : Poziomy M ( max 840 px szerokości )
    // h-l : Poziomy L ( max 1270 px szerokości )
    // preg_match( '/^(?:v|h)\-(?:s|m|l)$/', $type, $match );
    $parse = sscanf( $type, '%1s-%1s' );
    static $loaded = array();

    $std_meta_query = array(
      'relation'  =>  'AND',
      array(
        'key'       => 'uklad',
        'value'     => $type,
      ),
      array(
        'relation'  => 'OR',
        array(
          'key'           => 'sponsorowany',
          'compare_key'   => 'NOT EXISTS',
        ),
        array(
          'key'      => 'sponsorowany',
          'value'    => 'promo',
          'compare'  => '!=',
        ),
      ),
    );
    $promo_meta_query = array(
      'relation'  =>  'AND',
      array(
        'key'     => 'uklad',
        'value'   => $type,
      ),
      array(
        'key'     => 'sponsorowany',
        'value'   => 'promo',
      ),
    );

    $query = array(
      'numberposts'     => 1,
      'category_name'   => 'banner-reklamowy',
      'exclude'         => $loaded,
      'meta_query'      => $promo?( $promo_meta_query ):( $std_meta_query ),
      'orderby'         => 'rand',
    );

    $found = get_posts($query);
    // var_dump( $query );
    // var_dump( $found );

    if ( empty( $found ) ) return;

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
      return ;
    }

    printf(
      '<a %8$s class="adbox %6$s" href="%1$s" target="%2$s" data-type="%4$s">
        <img src="%3$s" alt="%7$s"/>
      </a>',
      $href,
      $target,
      $img,
      $type,
      $ad->ID,
      ( $parse[0] == 'h' and in_array( $parse[1], array( 'l', 'm' ) ) )?( 'no-padding' ):( '' ),
      $ad->post_title,
      ($target == '_blank')?('rel="noopener"'):('')
    );

  }

  function printGallery( $shortcode = null, $type = 'wordpress' ){
    global $fp;

    switch( $type ){
      case 'wordpress':
        preg_match( '/ids="([\d,]+)"/', $shortcode, $found );
        $ids = explode( ',', $found[1] );
        // var_dump( $ids );
        break;
      case 'filebird':
        $ids = array_map( function($arg){
          return (int)$arg;
        }, $shortcode );
        break;
    }


    return $fp->printUGallery( $ids, false );
    // return $fp->printSlick( $ids, false );
    // return $fp->printGallery( $ids, false );

  }

  // zwraca tablicę tablic id zdjęć znalezionych we wpisie
  function fetchPostGalleries( $content ){
    $ret = array();

    // STANDARDOWA GALERIA WP - NOWY EDYTOR
    preg_match_all( '~<\!\-\- wp:gallery.*?"ids":\[(.+?)\].*?/wp:gallery \-\->~ms', $content, $found );
    foreach ($found[1] as $k => $v) {
      $ret[] = explode( ',', $v );
    }

    // STANDARDOWA GALERIA WP - STARY EDYTOR
    preg_match_all( '~\[gallery.*?ids="(.+?)".*?\]~', $content, $found );
    foreach ($found[1] as $k => $v) {
      $ret[] = explode( ',', $v );
    }

    // GALERIA FILEBIRD - NOWY EDYTOR
    preg_match_all( '~<\!\-\- wp:filebird/block\-filebird\-gallery.+?/wp:filebird/block\-filebird\-gallery \-\->~ms', $content, $found );
    foreach ($found[0] as $k => $v) {
      preg_match_all( '~"id":(\d+)~', $v, $ids );
      $ret[] = $ids[1];
    }

    return $ret;
  }

  // wykrywanie urządzenia
  function getDevType( $echo = false ){
    static $devType = null;

    if ( !class_exists('Mobile_Detect') ) {
      include_once( get_template_directory() . '/php/Mobile_Detect.php' );
    }

    if ( $devType == null ) {
      $detect = new Mobile_Detect();

      if ( $detect->isMobile() ) {
        if ( $detect->isTablet() ) {
          // $devType = 'tablet';
          $devType = 'desktop';
        }
        else{
          $devType = 'smartphone';
        }
      }
      else {
        $devType = 'desktop';
      }

    }

    if ( $echo ) {
      echo $devType;
    }
    else {
      return $devType;
    }

  }

  // zwraca tablicę wpisów do wyświetlenie na pasku informacyjnym
  function getPilnePasek(){
    $homeID = get_page_by_title( 'home' )->ID;
    $limit = get_field( 'limit', $homeID );
    $kategorie = get_field( 'kategoria', $homeID );
    $tagi = get_field( 'tag', $homeID );
    $args_basic = array(
      'numberposts' => (int)$limit,
      'oderby'      => 'date',
      'order'       => 'DESC',
    );

    if ( !empty( $kategorie ) ) {
      $kategorie__in = array_map( function( $kat ){ return $kat->term_id; }, $kategorie );
      $args_kat = array_merge( $args_basic, array(
        'category__in' => $kategorie__in,
      ) );
    }

    if ( !empty( $tagi ) ) {
      $tagi__in = array_map( function( $tag ){ return $tag->term_id; }, $tagi );
      $args_tag = array_merge( $args_basic, array(
        'tag__in' => $tagi__in,
      ) );
    }

    $items = array_merge( get_posts( $args_kat ), get_posts( $args_tag ) );
    usort( $items, function( $a, $b ){
      if ( $a->post_date_gmt < $b->post_date_gmt ) {
        return 1;
      }
      elseif( $a->post_date_gmt > $b->post_date_gmt ) {
        return -1;
      }
      else{
        return 0;
      }

    } );

    return array_slice( $items, 0, $limit );
  }

  // zwraca tablicę wpisów do wyświetlenia w sekcji "zobacz również"
  function getPostMore( $args_user = array() ){
    $args_basic = array(
      'numberposts'   => 12,
      'orderby'       => 'date',
      'order'         => 'DESC',
    );
    $args = array_merge( $args_basic, $args_user );
    $ret = array();
    global $post_categories;

    $tags_list = wp_get_post_tags( get_post()->ID );
    if ( !empty( $tags_list ) ) {
      $tags_posts = get_posts( array_merge( $args, array(
        'tag__in'     => array_map( function( $t ){ return $t->term_id; }, $tags_list ),
      ) ) );

      $ret = array_merge( $ret, $tags_posts );

    }

    if ( count( $ret ) < (int)$args['numberposts'] ) {
      $posts = get_posts( array_merge( $args, array(
        'category__in'  => $post_categories,
        'numberposts'   => (int)$args['numberposts'] - count( $ret ),
        'orderby'       => 'rand',
      ) ) );

      $ret = array_merge( $ret, $posts );
    }

    return $ret;
  }

  // pobiera liczbę wyświetleń dla danego wpisu
  function getPostViews( $post_id = null ){
    $ret = false;
    $con = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

    if( !$con ) return $ret;
    $sql = "SELECT count FROM nttv_post_views WHERE period = 'total' AND id = {$post_id} LIMIT 1";
    $query = mysqli_query( $con, $sql );
    $ret = mysqli_fetch_object( $query )->count;

    mysqli_free_result( $query );
    mysqli_close( $con );
    return $ret;
  }

  // modyfikacja sposobu wyświetlania autora wpisu
  add_filter( 'custom_author', function( $arg ){
    $segments = explode( " ", $arg );
    return implode( "", array_map( function( $seg ){
      return sprintf(
        '%s.',
        substr( $seg, 0, 1 )
      );
    }, $segments ) );
    return $arg;
  } );

?>
