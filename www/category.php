<?php get_header(); ?>
<?php
  $category = get_category_by_path( $_SERVER['REQUEST_URI'], false );
  $posts = get_posts(array(
    'numberposts'   => 13,
    'cat'           => $category->cat_ID,
  ));
?>
<!-- Page Content -->
<div id="category" class="<?php echo getDevType() . " {$category->slug}"; ?> container">
    <?php if (DBG): ?>
      <div class="_posts">
        <!--
          <?php print_r( $posts ); ?>
        -->
      </div>
    <?php endif; ?>
    <div class="row no-gutters">
        <!-- Blog Entries Column -->
        <div class="col-12 col-sm">
          <!-- Title -->
          <h5 class="title-sidebar">
            <?php echo $category->name; ?>
          </h5>
          <?php if ( !empty( $posts) ): ?>
            <!-- BIG POST -->
            <?php
              $item = $posts[0];
              printf(
                '<a class="link_post big " href="%1$s">
                  <div class="big-post">
                    <div class="cover_img img1"></div>
                      <div class="post_news_big" style="background-image:url(%2$s);">
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
            <!-- MID POSTS -->
            <div id="" class="mid_post row no-gutters">
              <?php
                foreach ( array_slice( $posts, 1, 24 ) as $num => $item ){
                  // $thumb = get_post_meta( $item->ID, 'thumb', true );
                  $thumb = get_field( 'thumb', $item->ID );
                  $img = get_the_post_thumbnail_url( $item->ID, 'medium' );

                  printf(
                    '<div class="item col-6 col-lg-4" data-thumb="%5$s" data-img="%6$s">
                      <a href="%1$s" class="link_post_small">
                        <div class="small-post">
                          <div class="post_news_small">
                            <div class="cover_img img2" style="background-image:url(%2$s);"></div>
                          </div>
                          <span>%4$s %3$s</span>
                        </div>
                      </a>
                    </div>',
                    get_permalink( $item->ID ),
                    strlen( $thumb ) > 0?( get_template_directory_uri() . "/joomla_import/" . $thumb ):( $img ),
                    $item->post_title,
                    printTags( $item->ID ),
                    $thumb,
                    $img
                  );
                }
              ?>
              </button>
            </div>
            <?php if ( count($posts) == 13 ): ?>
              <button id="btn_more" class="col-12 fp-btn btn-more fw-bold position-relative" type="button" name="button" data-cmd="posts" data-category="<?php echo $category->slug; ?>">
                <div class="spinner position-absolute">
                  <div class="box position-absolute"> </div>
                </div>
                Załaduj więcej
              </button>
            <?php endif; ?>
            <!-- /row-->
            <!-- /before content -->
          <?php else: ?>
            <div class="noposts text-center text-uppercase fw-bold">
              Ta kategoria nie posiada jeszcze wpisów do wyświetlenia :(
            </div>
          <?php endif; ?>

        </div>
        <!-- / col -->
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
<!-- /.container -->
<?php get_footer(); ?>
