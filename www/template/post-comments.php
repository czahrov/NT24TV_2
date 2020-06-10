<?php
  $comments = get_comments(array(
    'post_id'       => get_the_ID(),
    'status'        => 'approve',
    'hierarchical'  => 'threaded',
  ));
?>
<div id="comments" class="col-md-12">
  <div class="clear-top"></div>
  <h5 class="title-sidebar">Komentarze</h5>

  <?php if (comments_open()): ?>
    <div class="comments">
      <?php
        comment_form(array(
          'fields' => array(
            'email'   => '',
            'url'     => '',
            'author' => sprintf(
                '<p class="comment-form-author">%s %s</p>',
                sprintf(
                    '<label for="author">%s</label>',
                    ($req ? ' <span class="required">*</span>' : '')
                ),
                sprintf(
                    '<input id="author" name="author" type="text" value="%s" size="30" maxlength="245" placeholder="Twój podpis*" pattern="(?=\S).+" %s />',
                    esc_attr($commenter['comment_author']),
                    // $html_req
                    'required'
                )
            ),
            'cookies' => '',
          ),
          'comment_notes_before'  => 'Komentarze muszą najpierw zostać zaakceptowane przez administratora. Redakcja nowytarg24.tv nie odpowiada za treść komentarzy internautów.',
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
  <?php endif; ?>
  <?php if ( !empty( $comments ) ): ?>
    <div class="que">
      <?php
      $comments_num = get_comments_number();
      if ($comments_num > 0) {
        printf(
          '<span>%u</span> %s',
          $comments_num,
          $comments_num == 1?('komentarz'):($comments_num < 5?('komentarze'):('komentarzy'))
        );
      }
      ?>
    </div>

    <div class="users-comments">
      <?php
        function comment_printer($comms, $level = 0){
          foreach ($comms as $comm) {
            if ($comm->user_id > 0) {
                $avatar = '<div class="user-image">
                  <div class="user-avatar">
                    <div class="image"></div>
                  </div>
                </div>';
            }
            else {
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
              $comm->user_id > 0?( get_bloginfo('name') ):( empty($comm->comment_author)?('*ANONIM*'):($comm->comment_author) ),
              get_comment_date( 'H:i d.m.Y', $comm->comment_ID ),
              $comm->comment_content,
              get_comment_reply_link(
                array(
                  'reply_text'  => 'Odpowiedz',
                  'max_depth'   => get_option('thread_comments_depth'),
                  'depth'       => $level+1,
                ),
                $comm->comment_ID,
                $comm->comment_post_ID
              ),
              $comm->comment_ID,
              $avatar
            );

            $children = $comm->get_children(array(
              'status' => 'approve',
            ));
            if (!empty($children)) {
              echo "<div class='answer-comment'>";
              comment_printer($children, $level+1);
              echo "</div>";
            }
          }
        }

        comment_printer($comments);
      ?>
    </div>
  <?php endif; ?>

</div>
