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

    // generuje html youtube playera
    public function genYoutubeVideo( $url = "", $args = array() ){
      $data = array_merge( array(
        'autoplay'  => true,
        'muted'     => true,
        'controls'  => 1,
        'detach'    => 1,
      ), $args );

      // https://www.youtube.com/watch?time_continue=1&v=yvcobYgRB-A
      // https://www.youtube.com/watch?v=qrtIxEFWgvQ
      preg_match( '~.+/(.*?v=)?([^\&\|]+)?~', $url, $match );
      // printf(
      //   '<iframe class="youtube_video" src="https://www.youtube.com/embed/%1$s" title="%2$s" allowfullscreen></iframe>',
      //   end( $match ),
      //   'Zobacz film'
      // );

      return sprintf(
        '<div class="video">
          <div class="exit"> X </div>
          <div class="yt-video" data-yt-video-id="%s" data-yt-video-muted="%u" data-yt-video-autoplay="%u" data-yt-video-control="%u" data-yt-video-detach="%u"></div>
        </div>',
        end( $match ),
        (int)$data['muted'],
        (int)$data['autoplay'],
        (int)$data['controls'],
        (int)$data['detach']
      );
    }

    // generuje html playera dla mediów z biblioteki mediów
    public function genMediaPlayer( $media = null, $args = array() ){
      if ( !$media instanceof WP_POST ) return false;
      $data = array_merge( array(
        'width'     => '100%',
        'height'    => '100%',
        'autoplay'  => false,
        'muted'     => true,
        'controls'  => true,
        'poster'    => false,
        'class'     => '',
      ), $args );

      return sprintf(
        '<video class="media_player %s" width="%s" height="%s" %s %s %s>
          <source src="%s" type="%s"/>
          Twoja przeglądarka nie obsługuje odtwarzacza mediów HTML5
        </video>',
        $data['class'],
        $data['width'],
        $data['height'],
        $data['controls'] == true?('controls'):(''),
        $data['muted'] == true?('muted'):(''),
        $data['autoplay'] == true?('autoplay'):(''),
        wp_get_attachment_url( $media->ID ),
        $media->post_mime_type
      );
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

    public function printSlick( $img_ids = array(), $echo = true ){
      $items = "";
      foreach ($img_ids as $img_id) {
        $items .= sprintf(
          '<a class="fpItem" href="%2$s" target="_blank" title="%3$s">
            <div style="background-image:url(%1$s);"></div>
          </a>',
          wp_get_attachment_image_url( $img_id, 'medium' ),
          wp_get_attachment_image_url( $img_id, 'full' ),
          get_the_title( $img_id )
        );
      }

      $ret = sprintf(
        '<div id="" class="slickGallery">
          <div class="items">%s</div>
          <div class="nav"> </div>
          <div class="dots"></div>
        </div>',
        $items
      );

      if ( $echo ) {
        echo $ret;
      } else {
        return $ret;
      }

    }

    public function printGallery( $img_ids = array(), $echo = true ){
      $items = "";
      foreach ($img_ids as $img_id) {
        $items .= sprintf(
          '<a class="fpLink" href="%2$s" target="_blank" style="background-image:url(%1$s);"></a>',
          wp_get_attachment_image_url( $img_id, 'thumbnail'),
          wp_get_attachment_image_url( $img_id, 'full')
        );
      }

      $ret = sprintf(
        '<div id="" class="fpGallery row justify-content-center">%s</div>',
        $items
      );

      if ( $echo ) {
        echo $ret;
      }
      else {
        return $ret;
      }

    }

  }
?>
