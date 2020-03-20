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

  liczbyPierwsze( 10000 );
?>
