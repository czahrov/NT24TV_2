<?php require_once('header.php'); ?>
<?php
  the_post();
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

          <div class="comment">
            <i class="icon">
              <img src="<?php echo get_template_directory_uri() . "/" ?>images/message.svg" onerror="this.onerror=null; this.src='#'" alt="komentarz">
            </i>
            <span class="comment_value">Super artykuł. Pozdrawiam
              <span class="author_comment">Sylwia</span>
            </span>
            <span class="comments_que">5</span>
          </div>

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

    <?php include('template/single/sidebar.php'); ?>
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
        <div id="comments" class="col-md-12">
          <div class="clear-top"></div>
          <h5 class="title-sidebar">Komentarze</h5>

          <div class="comments">
            <?php
              comment_form(array(
                'fields' => array(
                  // 'email'   => '',
                  // 'url'     => '',
                  'author' => sprintf(
                      '<p class="comment-form-author">%s %s</p>',
                      sprintf(
                          '<label for="author">%s</label>',
                          ( $req ? ' <span class="required">*</span>' : '' )
                      ),
                      sprintf(
                          '<input id="author" name="author" type="text" value="%s" size="30" maxlength="245" placeholder="Twój podpis"%s />',
                          esc_attr( $commenter['comment_author'] ),
                          $html_req
                      )
                  ),
                  'cookies' => '',
                ),
                'comment_notes_before'  => 'Komentarze muszą najpierw zostać zaakceptowane przez administratora. Twój adres e-mail nie zostani opublikowany.',
                'comment_field' => '<p class="comment-form-comment">
                  <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" placeholder="Napisz komentarz"></textarea>
                </p>',
                'title_reply'   => 'Napisz komentarz',
                'label_submit'  => 'Dodaj komentarz',
                'submit_button' => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
                // 'submit_field'  => '<p class="form-submit">%1$s %2$s</p>',
                'submit_field'  => '<div class="button-line">%1$s %2$s</div>',
              ));
            ?>
          </div>

          <div class="que">
            <?php
              $comments_num = get_comments_number();
              if ($comments_num > 0) {
                printf(
                  '<span>%u</span> %s',
                  $comments_num,
                  $comments_num == 1?( 'komentarz' ):( $comments_num < 5?( 'komentarze' ):( 'komentarzy' ) )
                );
              }
            ?>
          </div>

          <div class="users-comments">
            <?php
              $comments = get_comments(array(
                'post_id'       => get_the_ID(),
                'status'        => 'approve',
                'hierarchical'  => 'threaded',
              ) );

              function comment_printer( $comms, $level = 0 ){
                foreach ($comms as $comm) {
                  if ( $comm->user_id > 0 ) {
                    $avatar = '<div class="user-image">
                      <div class="user-avatar">
                        <div class="image"></div>
                      </div>
                    </div>';
                  } else {
                    $avatar = '';
                  }

                  printf(
                    '<div id="comment-%5$u" class="single-comment">
                      <div class="comment">
                        %6$s
                        <div class="comment-contents">
                          <div class="user-data">
                            <span class="author">%1$s</span>
                            <span class="separator"></span>
                            <span class="date">%2$s</span>
                          </div>
                          <p class="text">%3$s</p>
                        </div>
                      </div>
                      <div class="answer-btn">
                        <button> %4$s </button>
                      </div>
                    </div>',
                    empty($comm->comment_author)?( '*ANONIM*' ):( $comm->comment_author ),
                    $comm->comment_date,
                    $comm->comment_content,
                    get_comment_reply_link( array(
                      'reply_text'  => 'Odpowiedz',
                      'reply_to_text'  => 'Odpowiedź do %s',
                      'max_depth'   => get_option('thread_comments_depth'),
                      'depth'       => $level+1,
                    ), $comm->comment_ID, $comm->comment_post_ID ),
                    $comm->comment_ID,
                    $avatar
                  );

                  $children = $comm->get_children(array(
                    'status' => 'approve',
                  ));
                  if( !empty( $children ) ){
                    echo "<div class='answer-comment'>";
                    comment_printer( $children, $level+1 );
                    echo "</div>";
                  }

                }
              }

              comment_printer( $comments );
            ?>
          </div>

        </div>
        <!-- /col-md-12 -->
      </div>
      <?php include('template/single/more.php'); ?>

    </div>
    <!-- /col-8 -->

    <?php include('template/single/reportarze.php'); ?>
    <!-- /.row -->

  </div>
  <!-- /.container -->
</div>

<?php require_once('footer.php'); ?>
