<?php /* Template Name: test */ ?>
<?php get_header(); ?>
<?php
  global $fp;
  $text = "Nowotarskie dziedzictwo poligraficzne zyska drugie życie. Ponad 3 mln zł dotacji ze środków unijnych dla Miasta na realizację projektu pn. Śladem zabytków techniki z Podhala na Liptów.";
  $words = 6;
  preg_match( "~(\S+\s+){{$words}}~", $text, $match );
  // var_dump( $match );
  $ret = $match[0];
  if( strlen($text) > strlen($ret) ) $ret .= '(...)';
  print_r(array(
    'text'  => $text,
    'ret'   => $ret,
  ));
?>
<?php get_footer(); ?>
