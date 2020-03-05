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
    <div class="col-xl-8 col-sm-12 col-md-12 col-lg-12 single-post">

      <!-- Title -->
      <h2><?php the_title(); ?></h2>

      <div class="before-content">
        <div class="author_date_tags">
          <span class="author"><?php the_author(); ?></span>
          <span class="separator"></span>
          <span class="date"><?php the_date("d.m.Y"); ?></span>
          <span class="separator"></span>
          <span class="tag">Pilne</span>
        </div>

        <div class="share_comment">

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
              <img src="<?php echo get_template_directory_uri() . "/" ?>images/sh.svg" alt="Udostępnij">
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

        <img class="img-fluid" src="<?php the_post_thumbnail_url('full'); ?>">

        <?php the_content(); ?>

      </div>
      <!-- /content -->

    </div>
    <!-- / col -->

    <?php get_template_part('template/single/sidebar'); ?>
  </div>
  <!-- /.row -->

</div>
<!-- /.container -->

<div class="clear-top"></div>
<!-- Page Content -->
<div class="container">
  <div class="row no-gutters">
    <div class="col-xl-8 col-sm-12 col-md-12 col-lg-12 single-post">
      <div class="row no-gutters komentarze">
        <?php get_template_part('template/single/comments'); ?>

        <!-- /col-md-12 -->
      </div>
      <?php get_template_part('template/single/more'); ?>

    </div>
    <!-- /col-8 -->

    <?php get_template_part('template/single/reportarze'); ?>
    <!-- /.row -->

  </div>
  <!-- /.container -->
</div>

<?php get_footer(); ?>
