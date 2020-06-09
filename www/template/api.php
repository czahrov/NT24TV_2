<?php /* Template Name: API */ ?>
<?php
  $protocol = !empty( $_SERVER['REQUEST_SCHEME'] )?( $_SERVER['REQUEST_SCHEME'] ):( $_SERVER['HTTPS'] == 'on'?( 'https' ):( 'http' ) );
  $host = $_SERVER['HTTP_HOST'];
  define( 'BASE', "{$protocol}://{$host}" );
  // print_r( $_SERVER );
  // exit;
  if (
    $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest' ||
    strpos( $_SERVER['HTTP_REFERER'], BASE ) !== 0
  ) {
    header("Location:" . home_url(), true, 404 );
    exit;
  }

  $fp = get_facepalm();

  switch ( $_GET['cmd'] ) {
    case 'posts':
      $start = (int)$_GET['from'];
      $end = (int)$_GET['to'];
      $catSlug = $_GET['cat'];
      $isSpecialCategory = get_term_meta( get_category_by_slug( $catSlug )->cat_ID, 'front', true ) == 1;
      if( empty( $catSlug ) ){
        preg_match_all( "/[^\/]+/", $_SERVER['HTTP_REFERER'], $match );
        $catSlug = end( $match[0] );
      }

      $posts = get_posts(array(
        'offset'        => $start,
        'numberposts'   => $end,
        'category_name' => $catSlug,
      ));

      $ret = array_map( function( $item ) use ($fp){
        $title = addslashes( $item->post_title ) . printTags( $item->ID, true, $isSpecialCategory );
        $short_title = $fp->cutText( addslashes( $item->post_title ), 10 ) . printTags( $item->ID, true, $isSpecialCategory );
        $img = get_the_post_thumbnail_url( $item->ID, 'large' );
        $thumb_field = get_post_field( 'thumb', $item );
        $thumb = get_template_directory_uri() . "/joomla_import/" . $thumb_field;
        $nophoto = get_template_directory_uri() . '/images/no-photo2.png';
        $url = get_permalink( $item );
        return array(
          'title' => trim( $title ),
          'short_title' => trim( $short_title ),
          'url'   => $url,
          'img'   => $img !== false?( $img ):( !empty( $thumb_field )?( $thumb ):( $nophoto ) ),
        );
      }, $posts );

      echo json_encode( $ret );
      break;
    case 'search':
      $start = (int)$_GET['from'];
      $end = (int)$_GET['to'];
      $query = $_GET['q'];
      if ( strlen( $query ) < 3 ) break;

      $posts = get_posts(array(
        'offset'      => $start,
        'numberposts' => $end,
        's'           => $query,
        // 'order'       => 'ASC',
        // 'orderby'     => 'title',
      ));

      $ret = array_map( function( $item ) use ( $fp ){
        $title = addslashes( $item->post_title ) . printTags( $item->ID );
        $short_title = $fp->cutText( addslashes( $item->post_title ), 10 ) . printTags( $item->ID, true, $isSpecialCategory );
        $img = get_the_post_thumbnail_url( $item->ID, 'large' );
        $thumb = get_template_directory_uri() . "/joomla_import/" . get_post_field( 'thumb', $item );
        $url = get_permalink( $item->ID );
        return array(
          'title' =>  trim( $title ),
          'short_title' =>  $short_title,
          'url'   => $url,
          'img'   => $img !== false?( $img ):( $thumb ),
        );
      }, $posts );

      echo json_encode( $ret );
      break;
    default:
      // code...
      break;
  }
?>
