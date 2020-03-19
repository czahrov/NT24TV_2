<?php get_header(); ?>
<?php
  the_post();
  $last_comments = get_comments(array(
    'post_id'   => get_the_ID(),
    'status'    => 'approve',
    'number'    => 1,
    'orderby'   => 'comment_date',
    'order'     => 'DESC',
  ));

  $last_comment = $last_comments[0];
  $comments_num = get_comments(array(
    'post_id'   => get_the_ID(),
    'status'    => 'approve',
    'count'     => true,
  ));
?>
<!-- Page Content -->
<div id='post' class="container">
  <div class="row no-gutters">
    <!-- Blog Entries Column -->
    <div class="col-12 col-lg-8 single-post">

      <!-- Title -->
      <h2><?php the_title(); ?></h2>

      <div class="before-content">
        <div class="author_date_tags">
          <?php
            $segments = array(
              "<span class='author'>".get_the_author()."</span>",
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

        <div class="share_comment row justify-content-between">

          <div class="social_share">
            <span class="fb">
              <a href="<?php echo $fp->getSocialLink( 'facebook', get_the_permalink() ); ?>">
                <img src="<?php echo get_template_directory_uri() . "/" ?>images/fb.svg" alt="Facebook">
              </a>
            </span>
            <span class="twitter">
              <a href="<?php echo $fp->getSocialLink( 'twitter', get_the_permalink() ); ?>">
                <img src="<?php echo get_template_directory_uri() . "/" ?>images/twit.svg" alt="Twitter">
              </a>
            </span>
            <span class="share">
              <a class="clipboard" href="#" data-toggle="tooltip" title="Kopiuj adres strony do schowka">
                <img src="<?php echo get_template_directory_uri() . "/" ?>images/sh.svg" alt="Udostępnij">
              </a>
            </span>
          </div>

          <?php if ( !empty( $last_comment ) ): ?>
            <a class="comment d-flex" href="<?php echo "#comment-{$last_comment->comment_ID}"; ?>">
              <i class="icon">
                <img src="<?php echo get_template_directory_uri() . "/" ?>images/message.svg" alt="komentarz">
              </i>
              <span class="comment_value d-flex">
                <div class="content">
                  <?php echo $last_comment->comment_content; ?>
                </div>
                <span class="author_comment">
                  <?php echo $last_comment->comment_author; ?>
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

      <div class="content">

        <div class="zajawka">
          <?php the_excerpt(); ?>
        </div>

        <?php
          $vid_url = get_post_field('youtube');
          if( !empty( $vid_url ) ):
            preg_match( '/([^\/]+)$/', $vid_url, $match );
            $vid = $match[1];
        ?>
        <div class="video">
          <?php $fp->genYoutubeVideo( $vid ); ?>
        </div>
        <?php endif; ?>

        <?php
          $img = get_the_post_thumbnail_url( get_the_ID(), 'full' );
          $thumb = get_template_directory_uri() . "/joomla_import/" . get_post_field( 'thumb', get_the_ID() );
        ?>
        <img class="img-fluid" src="<?php echo $img !== false?( $img ):( $thumb ); ?>">

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

          $content = apply_filters( 'the_content', $content );

          foreach ($replace as $k => $v) {
            $content = str_replace( "%fp_g{$k}%", $replace[$k], $content );
          }

          echo $content;
        ?>

      </div>
      <!-- /content -->

    </div>
    <!-- / col -->

    <?php get_template_part('template/single/sidebar-top'); ?>
  </div>
  <!-- /.row -->

</div>
<!-- /.container -->

<div class="clear-top"></div>
<!-- Page Content -->
<div class="container">
  <div class="row no-gutters">
    <div class="col-12 col-lg-8 single-post">
      <div class="row no-gutters komentarze">
        <?php get_template_part('template/single/comments'); ?>

        <!-- /col-md-12 -->
      </div>
      <?php get_template_part('template/single/more'); ?>

    </div>
    <!-- /col-8 -->

    <?php get_template_part('template/single/sidebar-bot'); ?>
    <!-- /.row -->

  </div>
  <!-- /.container -->
</div>

<?php get_footer(); ?>
