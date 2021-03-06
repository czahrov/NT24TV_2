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
              get_the_date().' '.get_the_time(),
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
      <!-- /content -->
    </div>
    <!-- sidebar -->
    <!-- Sidebar Column -->
    <div class="sidebar sidebar-list col-12 col-lg-4 row no-gutters padding-lg d-lg-block">
      <div class="col-12 col-sm col-lg-12">
        <?php echo printAd( 'v-l', false, array( 'class'=> 'padding' ) ); ?>
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
    <div class="col-12 single-post">
      <?php get_template_part("template/post-more-nekrolog-desktop"); ?>
    </div>
    <!-- /col-8 -->
    <!-- /.row -->
  </div>
  <!-- /.container -->
</div>
