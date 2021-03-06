<?php
  global $fp, $comments_num, $last_comment;
?>
<div class="container">
  <div class="row no-gutters">
    <!-- Blog Entries Column -->
    <div class="single-post col-12 col-lg-8">
      <!-- Title -->
      <h2><?php the_title(); ?></h2>
      <div class="before-content">
        <div class="author_date_tags">
          <?php
            $segments = array(
              "<span class='date'>".get_the_date().' '.get_the_time()."</span>",
              printImportant( get_the_id(), false ),
              printFresh( get_the_id(), false ),
              printHot( get_the_id(), false ),
              getPostViews( get_post()->ID )
            );

            echo implode(
              '<span class="separator"></span>',
              array_filter( $segments, function( $item ){
                return !empty( $item );
              } )
            );
          ?>
        </div>
        <div class="share_comment row justify-content-between">
          <div class="social_share">
            <span class="fb">
              <a href="<?php echo $fp->getSocialLink( 'facebook', get_the_permalink() ); ?>">
                <img src="<?php echo get_template_directory_uri() . "/" ?>images/fb.svg" alt="udostępnij na Facebook">
              </a>
            </span>
            <span class="twitter">
              <a href="<?php echo $fp->getSocialLink( 'twitter', get_the_permalink() ); ?>">
                <img src="<?php echo get_template_directory_uri() . "/" ?>images/twit.svg" alt="udostępnij na Twitter">
              </a>
            </span>
            <span class="share">
              <a class="clipboard" href="#" data-toggle="tooltip" title="Kopiuj adres strony do schowka">
                <img src="<?php echo get_template_directory_uri() . "/" ?>images/sh.svg" alt="Skopiuj adres strony">
              </a>
            </span>
          </div>
          <?php
            global $last_comment;
            if ( !empty( $last_comment ) ):
          ?>
            <a class="comment d-flex ml-auto" href="<?php echo "#comment-{$last_comment->comment_ID}"; ?>">
              <i class="icon">
                <img src="<?php echo get_template_directory_uri() . "/" ?>images/message.svg" alt="komentarz">
              </i>
              <span class="comment_value row justify-content-end">
                <div class="content text-right">
                  <?php echo $last_comment->comment_content; ?>
                </div>
                <span class="author_comment">
                  <?php echo !strlen($last_comment->comment_author)?('*ANONIM*'):($last_comment->comment_author); ?>
                </span>
              </span>
              <span class="comments_que">
                <?php echo $comments_num; ?>
              </span>
            </a>
          <?php endif; ?>
        </div>
      </div>
      <!-- /before content -->
      <div class="content main padding-md">
        <?php if ( !empty( ( $yt = get_post_field('youtube') ) ) ): ?>
          <?php
            // echo $fp->genYoutubeVideo( $yt );
            $fp->embed_video_for_post( get_post() );
          ?>
        <?php endif; ?>
        <div class="zajawka">
          <?php
            $excerpt =  get_the_excerpt( get_post() );
            $lead =  get_field('lead');
            echo empty( $lead )?( $excerpt ):( $lead );
          ?>
        </div>
        <?php
          if( empty( $yt ) ){
            $thumb = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            $thumb_alt = get_template_directory_uri() . "/joomla_import/" . get_post_field( 'thumb', get_the_ID() );
            $img = $thumb !== false?( $thumb ):( $thumb_alt );

            if ( $img !== false ) {
              printf(
                '<img class="img-fluid" src="%s" alt="%s"/>',
                $img,
                $post->post_title
              );
            }
          }
        ?>
        <?php the_content(); ?>
      </div>
      <div class="after_content d-flex align-items-center">
        <span class="author fw-bold">
          <?php
            // echo apply_filters( 'custom_author', get_the_author() );
            echo get_the_author_meta('display_name');
          ?>
        </span>
        <span class='separator'></span>
        <span class='date'>
          <?php echo get_the_date("d.m.Y"); ?>
        </span>
      </div>
      <!-- timeline -->
      <style type="text/css">
        #live {
          background-color: #fff;
        }

        .relacjaLive .thumb {
          display: none !important;
        }

        .lead-relacja p {
          font-family: 'ws-extrabold';
          font-size: 1rem;
          margin-top: 1rem;
        }

        .timeline{
          max-width: 100%;
        }

        .timeline .date {
          font-weight: 800;
          position: relative;
          color: #000;
          padding-left: 10px;
        }

        .timeline img{
          max-width: 100%;
          height: auto;
        }

        .timeline span.date:before {
          content: '';
          position: absolute;
          left: -5px;
          background: #fff;
          top: 4px;
          width: 10px;
          height: 10px;
          border-radius: 100%;
          border: 1px solid #dcdcdc;
        }

        .timeline .message {
          border-left: 1px dashed #dcdcdc;
          margin: 0 10px;
          padding-bottom: 10px;
        }

        .timeline .message p {
          padding: 10px 0 0 10px;
        }

        .timeline ul {
          padding: 0;
          margin: 0;
        }

        .timeline ul li {
          /* padding: 20px 0; */
          list-style-type: none;
        }

        .timeline iframe {
          margin-left: 100px;
        }

        .timeline p {
          position: relative;
          width: 100%;
          padding-right: 30px;
        }

        /*tablet style*/
        @media (min-width: 240px) and (max-width: 1140px) {
          .fb_iframe_widget span {
            display: initial !important;
          }

          .timeline .fb-post {
            padding-left: 30px;
            padding-right: 30px;
          }

          .timeline .fb-post iframe {
            width: 100% !important;
          }

          .timeline iframe {
            margin-left: 0;
            width: 100%;
            height: auto;
            min-height: 300px;
            padding-right: 25px;
          }

          #live {
            background-color: #fff;
          }

          #live {
            height: 61px !important;
          }

          #live a.banner {
            height: 100px;
            width: 100%;
            background-size: contain;
          }
        }

        /*tablet style*/
        @media (min-width: 240px) and (max-width: 1140px) and (orientation: landscape) {
          .timeline iframe {
            padding-right: 25px;
            width: 100%;
            margin-left: 0;
            height: auto;
            min-height: 300px;
          }

          #live {
            background-color: #fff;
          }

          #live {
            height: 111px !important;
          }

          #live a.banner {
            height: 111px !important;
            width: 100%;
            background-size: contain;
          }

          .relacjaLive .wp-embed {
            padding: 25px;
            font-size: 14px;
            font-weight: 400;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            line-height: 1.5;
            color: #82878c;
            background: #fff;
            border: 1px solid #e5e5e5;
            box-shadow: none;
            overflow: hidden;
            zoom: 1;
          }
        }

      </style>
      <div class="timeline padding-md">
        <ul>
          <?php while (has_sub_field('timeline_items')): ?>
            <li>
              <div class="message">
                <span class="date">
                  <?php the_sub_field('timeline_date'); ?>
                </span>
                <?php the_sub_field('timeline_content'); ?>
              </div>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>

    </div>
    <!-- sidebar -->
    <!-- Sidebar Column -->
    <div class="sidebar sidebar-list col-12 col-lg-4 row no-gutters padding-lg d-lg-block">
      <div class="col-12 col-sm col-lg-12">
        <?php echo printAd( 'v-l', false, array( 'class' => 'padding' ) ); ?>
      </div>
      <div class="position-sticky col-12 col-sm-7 col-md-8 col-lg-12">
        <?php get_template_part('template/sidebar-popularne-desktop'); ?>
      </div>
    </div>
  </div>
  <!-- /.row -->
</div>
<div class="clear-top"></div>
<!-- Page Content -->
