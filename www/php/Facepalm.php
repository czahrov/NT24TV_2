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

    public function genYoutubeVideo( $videoID ){
      printf(
        '<iframe class="youtube_video" src="https://www.youtube.com/embed/%1$s" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
        $videoID
      );
    }

  }
