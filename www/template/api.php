<?php /* Template Name: API */ ?>
<?php
  define( 'BASE', "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}" );
  if (
    $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest' ||
    strpos( $_SERVER['HTTP_REFERER'], BASE ) !== 0
  ) {
    header("Location:" . BASE, true, 404 );
    exit;
  }


  switch ( $_GET['cmd'] ) {
    case 'posts':
      $start = (int)$_GET['from'];
      $end = (int)$_GET['to'];
      preg_match_all( "/[^\/]+/", $_SERVER['HTTP_REFERER'], $match );
      $catSlug = end( $match[0] );

      $posts = get_posts(array(
        'offset'        => $start,
        'numberposts'   => $end,
        'category_name' => $catSlug,
      ));

      $ret = array_map( function( $item ){
        $title = addslashes( $item->post_title );
        $img = get_the_post_thumbnail_url( $item->ID, 'large' );
        $url = get_permalink( $item->ID );
        return array(
          'title' => $title,
          'url'   => $url,
          'img'   => $img,
          'hot'   => isHot( $item->ID ),
        );
      }, $posts );

      echo json_encode( $ret );
    break;
    case 'search':
      $start = (int)$_GET['from'];
      $end = (int)$_GET['to'];
      $query = $_GET['q'];
      if ( strlen($query) < 4 ) break;

      $posts = get_posts(array(
        'offset'      => $start,
        'numberposts' => $end,
        's'           => $query,
        'order'       => 'ASC',
        'orderby'     => 'title',
      ));

      $ret = array_map( function( $item ){
        $title = addslashes( $item->post_title );
        $img = get_the_post_thumbnail_url( $item->ID, 'large' );
        $url = get_permalink( $item->ID );
        return array(
          'title' => $title,
          'url'   => $url,
          'img'   => $img,
        );
      }, $posts );

      echo json_encode( $ret );
    break;
    default:
      // code...
    break;
  }
?>
