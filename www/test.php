<?php /* Template Name: test */ ?>
<?php get_header(); ?>
<?php
  global $fp;
  print_r(array(
    'iphone'      => (int)$is_iphone,
    'chrome'      => (int)$is_chrome,
    'safari'      => (int)$is_safari,
    'netscape4'   => (int)$is_NS4,
    'opera'       => (int)$is_opera,
    'mac_IE'      => (int)$is_macIE,
    'win_IE'      => (int)$is_winIE,
    'firefox'     => (int)$is_gecko,
    'lynx'        => (int)$is_lynx,
    'IE'          => (int)$is_IE,
    'edge'        => (int)$is_edge,
  ));
  // $is_iphone (boolean) iPhone Safari
  // $is_chrome (boolean) Google Chrome
  // $is_safari (boolean) Safari
  // $is_NS4 (boolean) Netscape 4
  // $is_opera (boolean) Opera
  // $is_macIE (boolean) Mac Internet Explorer
  // $is_winIE (boolean) Windows Internet Explorer
  // $is_gecko (boolean) FireFox
  // $is_lynx (boolean)
  // $is_IE (boolean) Internet Explorer
  // $is_edge (boolean) Microsoft Edge
?>
<?php get_footer(); ?>
