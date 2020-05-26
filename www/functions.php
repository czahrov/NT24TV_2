<?php
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
  include_once( get_template_directory() . '/php/Facepalm.php' );
  global $fp;
  $fp = new Facepalm();

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

  // zastępowanie standardowych galerii WP oraz starych importowanych galerii galerią UGallery
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
    $old_gallery_path = get_field( 'gallery_name' );
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
        'thumb' => wp_get_attachment_image_url( $id, 'thumbnail' ),
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
    if( get_field( 'pilne', get_post()->ID ) == 1 ){
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

      if ( $detect->isMobile() ) {
        if ( $detect->isTablet() ) {
          $devType = 'tablet';
          // $devType = 'desktop';
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

    global $fp;
    $img = get_the_post_thumbnail_url( $item->ID, 'large' );
    $thumb = get_template_directory_uri() . "/joomla_import/" . get_post_field( 'thumb', $item );
    $data = array_merge( array(
      'title'   => $item->post_title,
      'img'     => $img !== false?( $img ):( $thumb ),
      'url'     => get_permalink( $item->ID ),
      'format'  => get_post_format( $item ),
      'class'   => '',
    ), $args );

    switch ( $type ) {
      case 'large':
        // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'large' );
        printf(
          '<div class="col-sm-12 col-12 col-lg-6 col-md-6 %s">
            <a href="%s" class="link_post_small" data-post-type="%s">
              <div class="small-post popular-post">
                %s
                <span>%s</span>
                <div class="post_news_small">
                  <div class="mask-popular"></div>
                  <div class="cover_img" style="background-image:url(%s);"></div>
                </div>
              </div>
            </a>
          </div>',
          $data['class'],
          $data['url'],
          $type,
          $data['format'] !== false?("<div class='{$data['format']}-post'></div>"):(''),
          $data['title'],
          $data['img']
        );
        break;
      case 'big':
        $data['title'] .= " " . printTags( $item->ID, true, false );
        if( get_post_format( $item ) == 'video' && get_field( 'home', $item->ID ) == 1 ){
          printf(
            '<div class="link_post big fc-black col-12 col-md-8 %s" data-post-type="%s">
              <div class="big-post">
                <div class="post_news_big">
                  %s
                </div>
              </div>
              <a href="%s" class="title fw-semibold padding"> %s </a>
            </div>',
            $data['class'],
            $type,
            $fp->embed_video_for_post( $item, array(), true ),
            $data['url'],
            $item->post_title
          );
        }
        else{
          // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'large' );
          printf(
            '<a class="link_post big col-12 col-md-8 %s" href="%s" data-post-type="%s">
              <div class="big-post">
                <div class="cover_img"></div>
                <div class="post_news_big" style="background-image:url(%s)">
                  <div class="content">
                    <span> %s </span>
                  </div>
                </div>
              </div>
            </a>',
            $data['class'],
            $data['url'],
            $type,
            $data['img'],
            $data['title']
          );
        }
        break;
      case 'big-special':
        $data['title'] .= " " . printTags( $item->ID, true, false );
        if( get_post_format( $item ) == 'video' && get_field( 'home', $item->ID ) == 1 ){
          printf(
            '<div class="link_post big fc-white col-12 col-md-8 %s" data-post-type="%s">
              <div class="big-post">
                <div class="post_news_big">
                  %s
                </div>
              </div>
              <a href="%s" class="title fw-semibold padding"> %s </a>
            </div>',
            $data['class'],
            $type,
            $fp->embed_video_for_post( $item, array(), true ),
            $data['url'],
            $data['title']
          );
        }
        else{
          // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'large' );
          printf(
            '<a class="link_post big col-12 col-md-8 %s" href="%s" data-post-type="%s">
              <div class="big-post">
                <div class="cover_img"></div>
                <div class="post_news_big" style="background-image:url(%s)">
                  <div class="content">
                    <span> %s </span>
                  </div>
                </div>
              </div>
            </a>',
            $data['class'],
            $data['url'],
            $type,
            $data['img'],
            $data['title']
          );
        }
        break;
      case 'mid':
        $data['title'] .= " " . printTags( $item->ID, true, true );
        // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'medium' );
        printf(
          '<div class="col-6 col-md-4 %s">
            <a href="%s" class="link_post_small" data-post-type="%s">
              <div class="small-post">
                <div class="post_news_small">
                  <div class="cover_img" style="background-image:url(%s)"></div>
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
          $data['img'],
          $data['title']
        );
        break;
      case 'mid-special':
        $data['title'] .= " " . printTags( $item->ID, true, false );
        // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'medium' );
        printf(
          '<div class="col-6 col-md-4 %s">
            <a href="%s" class="link_post_small" data-post-type="%s">
              <div class="small-post">
                <div class="post_news_small">
                  <div class="cover_img" style="background-image:url(%s)"></div>
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
          $data['img'],
          $data['title']
        );
        break;
      case 'side':
        $data['title'] .= " " . printTags( $item->ID, true, true );
        // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'thumbnail' );
        printf(
          '<a class="%s" href="%s" data-post-type="%s">
            <li>
              <div class="image-container">
                <div class="image" style="background-image:url(%s)"></div>
              </div>
              <span>%s</span>
            </li>
          </a>',
          $data['class'],
          $data['url'],
          $type,
          $data['img'],
          $data['title']
        );
        break;
      case 'side-special':
        $data['title'] .= " " . printTags( $item->ID, true, false );
        // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'thumbnail' );
        printf(
          '<a class="%s" href="%s" data-post-type="%s">
            <li>
              <div class="image-container">
                <div class="image" style="background-image:url(%s)"></div>
              </div>
              <span>%s</span>
            </li>
          </a>',
          $data['class'],
          $data['url'],
          $type,
          $data['img'],
          $data['title']
        );
        break;
      case 'side-big':
        // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'medium' );
        printf(
          '<a href="%s" class="single %s" title="%s" data-post-type="%s">
            <div class="image-container">
              <div class="image" style="background-image:url(%s);">
                <div class="video-post">
                  <img src="%s/images/play.svg" alt="odtwórz film"/>
                </div>
              </div>
            </div>
          </a>',
          $data['url'],
          $data['class'],
          $data['title'],
          $type,
          $data['img'],
          get_template_directory_uri()
        );
        break;
      case 'slider':
        $data['title'] .= " " . printTags( $item->ID, true, true );
        // $data['img'] = get_the_post_thumbnail_url( $item->ID, 'medium' );
        printf(
          '<div class="slide-content %s">
            <a href="%s" class="link_post_small" data-post-type="%s">
              <div class="small-post">
                <div class="post_news_small">
                  <div class="cover_img" style="background-image:url(%s)"></div>
                </div>
                <span>%s</span>
              </div>
            </a>
          </div>',
          $data['class'],
          $data['url'],
          $type,
          $data['img'],
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
    $abs_path_to_joomla = getcwd() . '/../web/nowytarg24.tv/wp-content/themes/NowyTargTV/joomla_import/';
    // var_dump($abs_path_to_joomla);
    $rel_path_to_joomla = get_template_directory_uri() . '/joomla_import/' . $path_to_dir;
    // var_dump($rel_path_to_joomla);
    $files = array_slice( scandir( $abs_path_to_joomla . $path_to_dir ), 2 );
    $files = array_filter( $files, function( $arg ){
      preg_match( '~(\d+x\d+)|(\.orig$)~', $arg, $found );
      if ( !empty( $found[0] ) ) {
        return false;
      }
      else {
        if( in_array( strtolower( pathinfo( $arg, PATHINFO_EXTENSION ) ), array( 'jpg', 'jpeg', 'png', 'bmp' ) ) ){
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

    return $files;
  }

?>
