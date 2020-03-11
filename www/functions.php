<?php
  date_default_timezone_set('Europe/Warsaw');
  add_theme_support('post-formats', array( 'gallery', 'video' ));
  add_theme_support('post-thumbnails');
  register_nav_menus(array(
    'main' => 'Menu główne, wyświetlane na górze strony',
  ));

  function isImportant( $id = null ){
    if( get_post_meta( $id, 'pilne', true ) == 1 ){
      return '<span class="tag">Pilne</span>';
    }
  }

  function isFresh( $id = null ){
    $timeNow = date_create()->getTimestamp();
    $timePost = date_create( get_the_date( 'Y-m-d H:i:s', $id ) )->getTimestamp();
    $timeLimit = 1 * 60 * 60;

    if( $timeNow - $timePost <= $timeLimit ){
      return '<span class="tag">Przed chwilą</span>';
    }
  }

  function isHot( $id = null ){
    if ( get_comments_number( $id ) >= 5 ) {
      return '<div class="hot"></div>';
    }
  }
