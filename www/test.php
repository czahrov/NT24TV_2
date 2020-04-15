<?php /* Template Name: test */ ?>
<?php
  function liczbyPierwsze( $ilosc = 1 ){
    $start = microtime( true );
    $liczby = array( 2 );
    $current = end( $liczby );

    while( count( $liczby ) < $ilosc ){
      $current++;
      $ok = true;
      foreach ( $liczby as $v ) {
        if ( $current % $v === 0 ) {
          $ok = false;
          break;
        }
        else{
          continue;
        }

      }

      if ( $ok ) {
        $liczby[] = $current;
      }
    }

    $stop = microtime( true );
    printf(
      'czas wykonania: %.3f s
      znalezionych liczb: %u',
      $stop - $start,
      count( $liczby )
    );
  }

  // liczbyPierwsze( 10000 );

  $homeID = get_page_by_title( 'home' )->ID;
  $kategorie = get_field( 'kategoria', $homeID );
  $tagi = get_field( 'tag', $homeID );
  $args_basic = array(
    'numberposts' => 10,
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

  print_r( $args );
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
  print_r( array_slice( $items, 0, 10 ) );
  // print_r( array_map( function( $a ){ return $a->post_date_gmt; }, $items ) );
  // print_r( $kategorie );
  // print_r( $tagi );

?>
