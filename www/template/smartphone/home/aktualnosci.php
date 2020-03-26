<?php
  $category = get_category_by_slug('aktualnosci');
  $items = get_posts(array(
    'numberposts'   => 13,
    'cat'           => $category->term_id,
    'orderby'       => 'date',
    'order'         => 'DESC'
  ));
?>
<!-- Page Content -->
<div id='aktualnosci' class="container">
  <div class="row no-gutters">
    <!-- Blog Entries Column -->
    <div class="col-12">
      <h5 class="title-sidebar">Aktualności</h5>
      <!-- Big Post -->
      <?php
        $item = $items[0];
        printf(
          '<a class="link_post item" href="%1$s">
            <div class="big-post">
              <div class="cover_img img1"></div>
              <div class="post_news_big" style="background-image:url(%2$s)">
                <span>
                  <div class="post-tags">
                    %4$s
                  </div>
                  %3$s
                </span>
              </div>
            </div>
          </a>',
          get_permalink( $item->ID ),
          get_the_post_thumbnail_url( $item->ID, 'full' ),
          $item->post_title,
          printTags( $item->ID, false )
        );
      ?>
      <div class="clear-top"></div>

      <div class="mid_post row no-gutters">
        <!-- Mid post -->
        <?php
          foreach( array_slice( $items, 1 ) as $item ){
            printf(
              '<div class="item col-6 col-md-4">
                <a class="link_post_small" href="%1$s">
                  <div class="small-post">
                    <div class="post_news_small">
                      <div class="cover_img img2" style="background-image:url(%2$s)"></div>
                    </div>
                    <span>%4$s %3$s</span>
                  </div>
                </a>
              </div>',
              get_permalink( $item->ID ),
              get_the_post_thumbnail_url( $item->ID, 'large' ),
              $item->post_title,
              printTags( $item->ID )
            );
          }
        ?>

      </div>
      <!-- /row-->

    </div>
    <!-- /col-8 -->
  </div>
  <!-- /.row -->
  <button id="btn_more" class="col-12 fp-btn btn-more fw-bold position-relative" type="button" name="button" data-cmd="posts" data-category="<?php echo $category->slug ?>">
    <div class="spinner position-absolute">
      <div class="box position-absolute"> </div>
    </div>
    Załaduj więcej
  </button>
  <!-- reklama pozioma -->
  <?php echo printAd('h-l'); ?>
  <!-- <div class="reklama-full-page">
    <div class="reklama">Reklama 1200x150px</div>
  </div> -->
</div>
<!-- /.container -->
<div class="clear-top"></div>
