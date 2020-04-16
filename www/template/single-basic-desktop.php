<?php
  global $fp, $comments_num;
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
              "<span class='date'>".get_the_date("d.m.Y")."</span>",
              printImportant( get_the_id(), false ),
              printFresh( get_the_id(), false ),
              printHot( get_the_id(), false )
            );

            echo implode(
              '<span class="separator"></span>',
              array_filter( $segments, function( $item ){
                return !empty( $item );
              } )
            );
          ?>
        </div>
        <?php
          global $last_comment;
        ?>
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
          <?php if ( !empty( $last_comment ) ): ?>
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
      <div class="content main padding no-padding-xl">
        <div class="zajawka">
          <?php
            // the_excerpt();
            echo get_field('lead');
          ?>
        </div>
        <?php if ( !empty( ( $yt = get_post_field('youtube') ) ) ): ?>
          <div class="video">
            <?php $fp->genYoutubeVideo( $yt ); ?>
          </div>
        <?php endif; ?>
        <?php
          if( empty( $yt ) ):
            $img = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            $thumb = get_template_directory_uri() . "/joomla_import/" . get_post_field( 'thumb', get_the_ID() );
        ?>
          <img class="img-fluid" src="<?php echo $img !== false?( $img ):( $thumb ); ?>" alt="<?php echo $post->post_title; ?>">
        <?php endif; ?>

        <?php
          $content = get_the_content();
          $replace = array();
          preg_match_all( '/\[gallery.*?\]/', $content, $found );
          foreach ( $found[0] as $k => $tag ) {
            // $replace = printGallery( $tag );
            // $content = str_replace( $tag, $replace, $content );
            $replace[] = printGallery( $tag );
            $content = str_replace( $tag, "%fp_g{$k}%", $content );
          }

          $content = apply_filters( 'the_content', $content ) . "<div class='author fw-bold'>".apply_filters( 'custom_author', get_the_author() )."</div>";

          foreach ($replace as $k => $v) {
            $content = str_replace( "%fp_g{$k}%", $replace[$k], $content );
          }

          echo $content;
        ?>

      </div>
      <!-- /content -->
    </div>
    <!-- sidebar -->
    <!-- Sidebar Column -->
    <div class="sidebar col-12 col-lg-4 row no-gutters padding-lg d-lg-block">
      <div class="col-12 col-sm col-lg-12">
        <?php echo printAd('v-l'); ?>
      </div>
      <div class="position-sticky col-12 col-sm-7 col-md-8 col-lg-12">
        <?php get_template_part('template/sidebar-nadchodzace-desktop'); ?>
      </div>
    </div>
  </div>
  <!-- /.row -->
</div>
<div class="clear-top"></div>
<!-- Page Content -->
<div class="container">
  <div class="row no-gutters">
    <!-- comments -->
    <div class="col-12 col-lg-8 single-post no-padding">
      <div class="row no-gutters komentarze">
        <?php get_template_part("template/post-comments"); ?>
      </div>
      <?php get_template_part("template/post-more-desktop"); ?>
    </div>
    <!-- /col-8 -->
    <div class="sidebar col-12 col-lg-4 row no-gutters padding-lg d-lg-block">
      <div class="col-12 col-sm col-lg-12">
        <?php echo printAd('v-l'); ?>
      </div>
      <div class="position-sticky col-12 col-sm-7 col-md-8 col-lg-12">
        <?php get_template_part('template/sidebar-popularne-desktop'); ?>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
</div>
