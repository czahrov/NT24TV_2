<?php
  /**
   *
   */
  class Facepalm{

    public function __construct( $arg ){
      // code...
    }

    public function getSocialLink( $name, $url, $text='', $img='' ){
      $ret = '';
      switch ($name) {
        case 'facebook':
          $ret = sprintf(
            'https://www.facebook.com/sharer/sharer.php?u=%s',
            htmlentities( $url )
          );
          break;
        case 'twitter':
          $ret = sprintf(
            'https://twitter.com/intent/tweet?url=%s&text=%s',
            htmlentities( $url ),
            htmlentities( $text )
          );
          break;
        case 'pinterest':
          $ret = sprintf(
            'http://pinterest.com/pin/create/button/?url=%s&media=%s&description=%s',
            htmlentities( $url ),
            $img,
            htmlentities( $text )
          );
          break;
        case 'linkedin':
          $ret = sprintf(
            'http://www.linkedin.com/shareArticle?mini=true&url=%s&title=%s',
            htmlentities( $url ),
            htmlentities( $text )
          );
          break;
        case 'tumblr':
          $ret = sprintf(
            'http://www.tumblr.com/share?v=3&u=%s&t=%s',
            htmlentities( $url ),
            htmlentities( $text )
          );
          break;
        default:

          break;
      }

      return $ret;
    }

    public function printUGallery( $img_ids = array(), $echo = true ){
    static $num = 1;
    $ret = "<div id='UGallery_{$num}' style='display:none'>";

    foreach ( $img_ids as $img_id ) {
      $title = get_the_title( (int)$img_id );
      $img_full = wp_get_attachment_image_url( (int)$img_id, 'full' );
      $img_thumb = wp_get_attachment_image_url( (int)$img_id, 'thumbnail' );

      $ret .= sprintf(
        '<img class="no-lazy" alt="%1$s" src="%2$s" data-image="%3$s" data-description="%1$s" data-no-lazy="1"/>',
        $title,
        $img_thumb,
        $img_full
      );

    }

    $ret .= "</div>";
    $num++;
    if ( $echo ) {
      echo $ret;
    }
    else{
      return $ret;
    }
  }

    public function printUGalleryFromArray( $imgs = array(), $echo = true ){
      if( count($imgs) == 0 ) return;
      $ret = "<div id='UGallery' style='display:none'>";

      foreach ( $imgs as $img ) {
        // $title = get_the_title( (int)$img_id );
        $title = basename( $img['full'] );
        // $img_full = wp_get_attachment_image_url( (int)$img_id, 'full' );
        // $img_thumb = wp_get_attachment_image_url( (int)$img_id, 'thumbnail' );

        $ret .= sprintf(
          '<img class="no-lazy" alt="%1$s" src="%2$s" data-image="%3$s" data-description="%1$s" data-no-lazy="1"/>',
          $title,
          $img['thumb'],
          $img['full']
        );

      }

      $ret .= "</div>";
      $num++;
      if ( $echo ) {
        echo $ret;
      }
      else{
        return $ret;
      }
    }

    public function embed_video_for_post( $post = null, $options = array(), $echo = false ){
      $wp_post = false;
      if ( is_numeric( $post ) ) {
        $wp_post = get_post( $post );
      }
      elseif( $post instanceof WP_POST ) {
        $wp_post = $post;
      }

      $options = array_merge( array(
        'autoplay'    => get_field( 'autoplay', $wp_post->ID ),
        'mute'        => get_field( 'mute', $wp_post->ID ),
        'controls'    => 1,
        'loop'        => get_field( 'loop', $wp_post->ID ),
        'pin'         => get_field( 'pin', $wp_post->ID ),
        'class'       => '',
        'width'       => '100%',
        'height'      => '100%',
      ), $options );

      $media = get_field( 'media', $wp_post->ID );
      $youtube = get_field( 'youtube', $wp_post->ID );
      $source = get_field( 'source', $wp_post->ID );

      if ( $source ) {
        $video_type_name = $source;
      }
      else {
        if ( $youtube ) {
          $video_type_name = 'youtube';
        }
        elseif( $media ) {
          $video_type_name = 'media';
        }

      }

      if( $wp_post !== false ){
        $player_html = "";
        switch ( $video_type_name ) {
          case 'media':
            // generate attributes for media player
            $attributes = array(
              'width'         => '100%',
              'height'        => '100%',
              'video'         => $video_ID,
              'player-type'   => $video_type_name,
              'controls'      => (int)$options['controls'],
              'autoplay'      => (int)$options['autoplay'],
              'muted'         => (int)$options['mute'],
              'loop'          => (int)$options['loop'],
              'detachable'    => (int)$options['detachable'],
              'pin'           => (int)$options['pin'],
            );
            $atts = array();
            foreach ($attributes as $k => $v) {
              $atts[] = 'data-'.$k.'="'.$v.'"';
            }

            $player_html = sprintf(
              '<video class="player %s" controls="%u" autoplay="%u" %s>
                <source src="%s" type="%s"/>
                Twoja przeglądarka nie obsługuje odtwarzacza mediów HTML5
              </video>',
              $options['class'],
              $attributes['controls'],
              $attributes['autoplay'],
              implode( ' ', $atts ),
              $media['url'],
              $media['mime_type']
            );
            break;
          case 'youtube':
            // youtube video url examples
            // https://www.youtube.com/watch?v=QYVjcIpvt10
            // https://youtu.be/FUpza22te6g
            $pattern = '~(?:(?:&|\?)v=|youtu\.be/)([\w\-]+)~i';
            preg_match( $pattern, $youtube, $match );
            $video_ID = $match[1];

            // generate attributes for youtube player
            $attributes = array(
              'width'         => '100%',
              'height'        => '100%',
              'video'         => $video_ID,
              'player-type'   => $video_type_name,
              'controls'      => (int)$options['controls'],
              'autoplay'      => (int)$options['autoplay'],
              'muted'         => (int)$options['mute'],
              'loop'          => (int)$options['loop'],
              'detachable'    => (int)$options['detachable'],
              'pin'           => (int)$options['pin'],
            );
            $atts = array();
            foreach ($attributes as $k => $v) {
              $atts[] = 'data-'.$k.'="'.$v.'"';
            }

            // generate HTML for youtube player
            $player_html = sprintf(
              '<div class="player %s" %s></div>',
              $options['class'],
              implode( ' ', $atts )
            );
            break;
          default:
            echo "<!-- VIDEO: NIE USTAWIONO ŹRÓDŁA -->";
            return false;
            break;
        }

        $output = sprintf(
          '<div id="video" class="%s %s">
            %s
            <div class="overlay fw-bold fc-white">
              <img src="%s/images/mute.svg"/> Włącz dźwięk
            </div>
          </div>',
          $video_type_name,
          $options['mute'] == 1?('mute'):(''),
          $player_html,
          get_template_directory_uri()
        );

        if ( $echo ) {
          return $output;
        }
        else {
          echo $output;
        }


      }

    }

    public function cutText( $text = "", $words = 6 ){
      preg_match( "~(\S+\s*){0,{$words}}~", $text, $match );
      $ret = $match[0];
      if( strlen($text) > strlen($ret) ) $ret .= '(...)';
      return $ret;
    }
    
  }
?>
