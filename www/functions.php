<?php
  // admin: adam@przybylski.name
  // header( "Cache-Control: max-age=31536000" );
  // header( "Cache-Control: private, no-cache, no-store, must-revalidate, max-age=1" );
  // header( "Pragma: no-cache", false );
  // date_default_timezone_set('Europe/Warsaw');
  error_reporting( E_ALL & ~E_WARNING & ~E_NOTICE );

  add_theme_support('post-formats', array( 'gallery', 'video' ));
  add_theme_support('post-thumbnails');
  register_nav_menus(array(
    'main' => 'Menu główne, wyświetlane na górze strony',
  ));

  // Facepalm
  function get_facepalm(){
    static $handler = null;

    if( !class_exists('Facepalm') ){
      include_once( get_template_directory() . '/php/Facepalm.php' );
    }

    if( $handler == null ) {
      $handler = new Facepalm();
    }

    return $handler;
  }
  global $fp;
  $fp = get_facepalm();

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

  // zastępowanie standardowych galerii WP, galerii FileBird oraz starych importowanych galerii galerią UGallery
  add_filter( 'the_content', function( $content ){
    global $fp;
    // tablica numerów ID zdjęć
    $images_ids = array();
    // tablica adres url grafik, zarówno miniatur 'thumb' jak i pełnych grafik 'full'
    $images_url = array();

    // NOWY EDYTOR - podmiana segmentów
    preg_match_all( '~<\!\-\- wp:gallery.*?"ids":\[(.+?)\].*?/wp:gallery \-\->~ms', $content, $found );
    foreach ($found[1] as $k => $v) {
      // $content = str_replace( $found[0][$k], printGallery( explode( ',', $v ), false ), $content );
      $content = str_replace( $found[0][$k], '', $content );
      $images_ids = array_merge( $images_ids, explode( ',', $v ) );
    }

    //STARY EDYTOR - podmiana segmentów
    preg_match_all( '~\[gallery.*?ids="(.+?)".*?\]~', $content, $found );
    foreach ($found[1] as $k => $v) {
      // $content = str_replace( $found[0][$k], printGallery( explode( ',', $v ), false ), $content );
      $content = str_replace( $found[0][$k], '', $content );
      $images_ids = array_merge( $images_ids, explode( ',', $v ) );
    }

    // NOWY EDYTOR - podmiana segmentów
    preg_match_all( '~<\!\-\- wp:filebird/block\-filebird\-gallery.+?/wp:filebird/block\-filebird\-gallery \-\->~ms', $content, $found );
    foreach ($found[0] as $k => $v) {
      preg_match_all( '~"id":(\d+)~', $v, $ids );
      // $content = str_replace( $v, printGallery( $ids[1], false ), $content );
      $content = str_replace( $v, '', $content );
      $images_ids = array_merge( $images_ids, $ids[1] );
    }

    // stare galerie importowane z joomli
    $old_gallery_path = get_field( 'gallery_name', get_post()->ID );
    if ( $old_gallery_path !== false ) {
      // $content .= $fp->printOldUGallery( fetch_old_gallery( $old_gallery_path ) );
      foreach ( fetch_old_gallery( $old_gallery_path ) as $img_url ) {
        $images_url[] = array(
          'thumb' => $img_url,
          'full' => $img_url,
        );
      }
    }

    // wypełnianie tablicy z adresami url grafik
    foreach ( $images_ids as $id ) {
      $images_url[] = array(
        'thumb' => wp_get_attachment_image_url( $id, 'medium' ),
        'full' => wp_get_attachment_image_url( $id, 'full' ),
      );
    }

    $content .= $fp->printUGalleryFromArray( $images_url, false );

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

  // generuje oznaczenie wpisu "pilne"
  function printImportant( $id = null, $icon = false ){
    if( get_field( 'pilne', $id ) == 1 ){
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

  // generuje oznaczenie wpisu "przed chwilą"
  function printFresh( $id = null, $icon = false ){
    $timeNow = date_create()->getTimestamp();
    // $timePost = date_create( get_the_date( 'Y-m-d H:i:s', $id ) )->getTimestamp();
    $timePost = get_post_datetime( $id )->getTimestamp();
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

  // generuje oznaczenie wpisu "trwa dyskusja"
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

  // generuje ikonkę rodzaju wpisu video/gallery
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

  // wypisuje oznaczenia dla wpisu
  function printTags( $id = null, $icon = true, $blackIcon = true ){
    return sprintf(
      '%s %s %s %s',
      printFresh( $id, $icon ),
      printImportant( $id, $icon ),
      printHot( $id, $icon ),
      printFormat( $id, $icon, $blackIcon )
    );
  }

  // generuje reklamę
  function printAd( $type = null, $promo = false, $args = array() ){
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
      '<a %s class="adbox %s" href="%s" target="%s" data-type="%s" title="%7$s">
        <img data-imglazy="%s" alt="%s"/>
      </a>',
      ($target == '_blank')?('rel="noopener"'):(''),
      $args['class'],
      $href,
      $target,
      $type,
      $img,
      $ad->post_title
    );

  }

  // generuje galerię mediów o podanych id
  function printGallery( $ids = array(), $echo = true ){
    global $fp;

    return $fp->printUGallery( $ids, $echo );
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

  // wykrywanie rodzaju urządzenia ( smartphone, tablet, desktop )
  function getDevType( $echo = false ){
    static $devType = null;

    if ( !class_exists('Mobile_Detect') ) {
      include_once( get_template_directory() . '/php/Mobile_Detect.php' );
    }

    if ( $devType == null ) {
      $detect = new Mobile_Detect();
      $helper = get_facepalm()->mobile_detect_ios_helper();

      if ( $detect->isMobile() || $helper == 'mobile' ) {
        if ( $detect->isTablet() || $helper == 'tablet' ) {
          $devType = 'tablet';
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

  // wykrywanie rodzaju systemu ( Android, iOS )
  function getOSType( $echo = false ){
    static $osType = null;

    if ( !class_exists('Mobile_Detect') ) {
      include_once( get_template_directory() . '/php/Mobile_Detect.php' );
    }

    if ( $osType == null ) {
      $detect = new Mobile_Detect();

      if ( $detect->isiOS() ) {
        $osType = 'ios';
      }
      elseif( $detect->isAndroidOS() ){
        $osType = 'androidos';
      }
      else{
        $osType = 'unknownos';
      }

    }

    if ( $echo ) {
      echo $osType;
    }
    else {
      return $osType;
    }

  }

  // zwraca tablicę wpisów do wyświetlenie na pasku informacyjnym
  function getPilnePasek(){
    $homeID = get_page_by_title( 'home' )->ID;
    $limit = get_field( 'limit', $homeID );
    return get_posts(array(
      'numberposts'   => $limit,
      'meta_query'    => array(
        'relation' => 'AND',
        array(
          'key'   => 'pilne',
          'value' => '1',
        ),
      ),
    ));
  }

  // zwraca tablicę wpisów do wyświetlenia w sekcji "zobacz również"
  function getPostMore( $args_user = array() ){
    // $post_id = 11318;
    $post_id = get_post()->ID;
    $posts_limit = 12;
    $post_categories = wp_get_post_categories( $post_id, array(
      'child_of' => 68,
    ) );

    $similar_posts = get_posts(array(
      'numberposts'   =>  $posts_limit,
      'cat'  =>  array_slice( $post_categories, -1 ),
      'exclude' => get_post()->ID,
    ));

    return $similar_posts;
  }

  // zwraca liczbę wyświetleń dla danego wpisu
  function getPostViews( $post_id = null, $pattern = "Stronę wyświetlono %u razy" ){
    // Home page, ID:40
    if ( get_field( 'prezentacja', 40 ) == 1 ) {
      $con = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

      if( !$con ) return $ret;
      $sql = "SELECT count FROM nttv_post_views WHERE period = 'total' AND id = {$post_id} LIMIT 1";
      $query = mysqli_query( $con, $sql );
      $ret = mysqli_fetch_object( $query )->count;

      mysqli_free_result( $query );
      mysqli_close( $con );

      return sprintf(
        $pattern,
        $ret
      );
    }
    return false;
  }

  // generuje kafelki wpisów
  function printPost( $post = null, $type = null, $args = array() ){
    // return '';
    $item = null;
    if ( $post instanceof WP_POST ) {
      $item = $post;
    }
    elseif( is_numeric( $post ) ) {
      $item = get_post( $post );
    }
    else{
      return false;
    }

    global $fp, $cat;
    $thumb_field = get_post_field( 'thumb', $item );
    $thumb = get_template_directory_uri() . "/joomla_import/" . $thumb_field;
    $data = array_merge( array(
      'title'       => htmlentities( $item->post_title ),
      // 'img'         => $img !== false?( $img ):( !empty( $thumb_field )?( $thumb ):( get_template_directory_uri()."/images/no-photo.png" ) ),
      'url'         => get_permalink( $item->ID ),
      'format'      => get_post_format( $item ),
      'class'       => '',
      'img_size'    => 'full',
      'title_limit' => false,
    ), $args );
    // skrócona wersja tytułu, wyświetlana w kafelkach na stronie
    $short_title = $fp->cutText( $data['title'], $data['title_limit'] );
    $img = get_the_post_thumbnail_url( $item->ID, $data['img_size'] );
    // brak zdefiniowanej miniaturki
    if ( $img == false ){
      // czy podano źródło youtube
      if ( get_field( 'source', $item->ID ) == 'youtube' && !empty( get_field( 'youtube', $item->ID ) ) ) {
        $img = $fp->get_youtube_thumbnail_url( get_field( 'youtube', $item->ID ) );
      }
      // czy istnieje stara miniaturka
      elseif( !empty( $thumb_field ) ) {
        $img = $thumb;
      }
      // brak zdjęcia
      else{
        $img = get_template_directory_uri()."/images/no-photo.png";
      }

    }

    switch ( $type ) {
      case 'large':
        // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'large' );
        printf(
          '<div class="col-12 col-md-6 %s">
            <a href="%s" class="link_post_small" data-post-type="%s" title="%s">
              <div class="small-post popular-post">
                %s
                <span>%s</span>
                <div class="post_news_small">
                  <div class="mask-popular"></div>
                  <div class="cover_img" data-bglazy="%s"></div>
                </div>
              </div>
            </a>
          </div>',
          $data['class'],
          $data['url'],
          $type,
          $data['title'],
          $data['format'] !== false?("<div class='{$data['format']}-post'></div>"):(''),
          $short_title,
          $img
        );
        break;
      case 'big':
        // $data['title'] .= " " . printTags( $item->ID, true, false );
        if( get_post_format( $item ) == 'video' && get_field( 'home', $item->ID ) == 1 ){
          printf(
            '<div class="link_post big video fc-white col-12 col-md-8 %s" data-post-type="%s">
              <div class="row no-gutters">
                <div class="big-post col-9">
                  <div class="post_news_big">
                    %s
                  </div>
                </div>
                <a href="%s" class="title fw-semibold col-3 bg-red" title="%s"> %s </a>
              </div>
            </div>',
            $data['class'],
            $type,
            $fp->embed_video_for_post( $item, array('class'=>''), true ),
            $data['url'],
            $data['title'],
            $short_title." ".printTags( $item->ID, true, false )
          );
        }
        else{
          // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'large' );
          printf(
            '<a class="link_post big col-12 col-md-8 %s" href="%s" data-post-type="%s" title="%6$s">
              <div class="big-post">
                <div class="cover_img"></div>
                <div class="post_news_big" data-bglazy="%s">
                  <div class="content">
                    <span> %s </span>
                  </div>
                </div>
              </div>
            </a>',
            $data['class'],
            $data['url'],
            $type,
            $img,
            $short_title." ".printTags( $item->ID, true, false ),
            $data['title']
          );
        }
        break;
      case 'big-special':
        // $data['title'] .= " " . printTags( $item->ID, true, false );
        if( get_post_format( $item ) == 'video' && get_field( 'home', $item->ID ) == 1 ){
          printf(
            '<div class="link_post big video fc-white col-12 col-sm-8 %s" data-post-type="%s">
              <div class="row no-gutters">
                <div class="big-post col-9">
                  <div class="post_news_big">
                    %s
                  </div>
                </div>
                <a href="%s" class="title fw-semibold col-3" style="background-color:%s" title="%s"> %s </a>
              </div>
            </div>',
            $data['class'],
            $type,
            $fp->embed_video_for_post( $item, array('class'=>''), true ),
            $data['url'],
            $data['pasek'],
            $data['title'],
            $short_title." ".printTags( $item->ID, true, false )
          );
        }
        else{
          // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'large' );
          printf(
            '<a class="link_post big col-12 col-md-8 %s" href="%s" data-post-type="%s" title="%6$s">
              <div class="big-post">
                <div class="cover_img"></div>
                <div class="post_news_big" data-bglazy="%s">
                  <div class="content">
                    <span> %s </span>
                  </div>
                </div>
              </div>
            </a>',
            $data['class'],
            $data['url'],
            $type,
            $img,
            $short_title." ".printTags( $item->ID, true, false ),
            $data['title']
          );
        }
        break;
      case 'mid':
        // $data['title'] .= " " . printTags( $item->ID, true, true );
        // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'medium' );
        printf(
          '<div class="col-6 col-sm-4 %s">
            <a href="%s" class="link_post_small" data-post-type="%s" title="%6$s">
              <div class="small-post">
                <div class="post_news_small">
                  <div class="cover_img" data-bglazy="%s"></div>
                </div>
                <div class="content">
                  <span> %s </span>
                </div>
              </div>
            </a>
          </div>',
          $data['class'],
          $data['url'],
          $type,
          $img,
          $short_title." ".printTags( $item->ID, true, true ),
          $data['title']
        );
        break;
      case 'mid-special':
        // $data['title'] .= " " . printTags( $item->ID, true, false );
        // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'medium' );
        printf(
          '<div class="col-6 col-sm-4 %s">
            <a href="%s" class="link_post_small" data-post-type="%s" title="%6$s">
              <div class="small-post">
                <div class="post_news_small">
                  <div class="cover_img" data-bglazy="%s"></div>
                </div>
                <div class="content">
                  <span> %s </span>
                </div>
              </div>
            </a>
          </div>',
          $data['class'],
          $data['url'],
          $type,
          $img,
          $short_title." ".printTags( $item->ID, true, false ),
          $data['title']
        );
        break;
      case 'side':
        // $data['title'] .= " " . printTags( $item->ID, true, true );
        // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'thumbnail' );
        printf(
          '<a class="%s" href="%s" data-post-type="%s" title="%6$s">
            <li>
              <div class="image-container">
                <div class="image" data-bglazy="%s"></div>
              </div>
              <span>%s</span>
            </li>
          </a>',
          $data['class'],
          $data['url'],
          $type,
          $img,
          $short_title." ".printTags( $item->ID, true, true ),
          $data['title']
        );
        break;
      case 'side-special':
        // $data['title'] .= " " . printTags( $item->ID, true, false );
        // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'thumbnail' );
        printf(
          '<a class="%s" href="%s" data-post-type="%s" title="%6$s">
            <li>
              <div class="image-container">
                <div class="image" data-bglazy="%s"></div>
              </div>
              <span>%s</span>
            </li>
          </a>',
          $data['class'],
          $data['url'],
          $type,
          $img,
          $short_title." ".printTags( $item->ID, true, false ),
          $data['title']
        );
        break;
      case 'side-big':
        // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'medium' );
        printf(
          '<a href="%s" class="single %s" data-post-type="%s" title="%s">
            <div class="image-container">
              <div class="image" data-bglazy="%s">
                <div class="video-post">
                  <img src="%s/images/play.svg" alt="odtwórz film"/>
                </div>
              </div>
            </div>
          </a>',
          $data['url'],
          $data['class'],
          $type,
          $data['title'],
          $img,
          get_template_directory_uri()
        );
        break;
      case 'slider':
        // $data['title'] .= " " . printTags( $item->ID, true, true );
        // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'medium' );
        printf(
          '<div class="slide-content %s">
            <a href="%s" class="link_post_small" data-post-type="%s" title="%6$s">
              <div class="small-post">
                <div class="post_news_small">
                  <div class="cover_img" data-bglazy="%s"></div>
                </div>
                <span>%s</span>
              </div>
            </a>
          </div>',
          $data['class'],
          $data['url'],
          $type,
          $img,
          $short_title." ".printTags( $item->ID, true, true ),
          $data['title']
        );
        break;
      default:
        // code...
        break;
    }
  }

  // funkcja ładująca szablony w zależności od rodzaju urządzenia
  function templateLoader( $file ){
    $types = array( 'smartphone', 'tablet', 'desktop' );
    $current = getDevType();
    if ( is_array( $file ) ) {
      foreach ($file as $n => $f) {
        templateLoader( $f );
      }
    }
    else {
      $base = get_template_directory()."/";
      // var_dump( sprintf( $base.$file.".php", $current ) );
      if ( file_exists( sprintf( $base.$file."php", $current ) ) ) {
        get_template_part( sprintf( $file, $current ) );
      }
      else {
        for( $i = array_search( $current, $types ); $i < count( $types ); $i++ ){
          if ( file_exists( sprintf( $base.$file.".php", $types[$i] ) ) ) {
            // var_dump( sprintf( $base.$file.".php", $types[$i] ) );
            get_template_part( sprintf( $file, $types[$i] ) );
            break;
          }
        }
      }

    }

  }

  function fetch_old_gallery( $path_to_dir = "" ){
    $abs_path_to_joomla = get_template_directory() . '/joomla_import/' . $path_to_dir;
    $rel_path_to_joomla = get_template_directory_uri() . '/joomla_import/' . $path_to_dir;
    $files = array_slice( scandir( $abs_path_to_joomla ), 2 );
    $files = array_filter( $files, function( $arg ) use ($abs_path_to_joomla){
      $file_path = "{$abs_path_to_joomla}/{$arg}";
      // echo $file_path . PHP_EOL;
      preg_match( '~(\d+x\d+)|(\.orig$)~', $arg, $found );
      if ( !empty( $found[0] ) ) {
        return false;
      }
      else {
        if( in_array( strtolower( pathinfo( $arg, PATHINFO_EXTENSION ) ), array( 'jpg', 'jpeg', 'png', 'bmp' ) ) && file_exists( $file_path ) ){
          return true;
        }
        else{
          return false;
        }

      }

    });
    $files = array_map( function( $arg ) use ($rel_path_to_joomla){
      return sprintf(
        '%s/%s',
        $rel_path_to_joomla,
        $arg
      );
    }, $files );
    // var_dump(array(
    //   'cwd' => getcwd(),
    //   '$path_to_dir' => $path_to_dir,
    //   '$abs_path_to_joomla' => $abs_path_to_joomla,
    //   '$rel_path_to_joomla' => $rel_path_to_joomla,
    //   '$files' => $files,
    // ));

    return $files;
  }

?>
