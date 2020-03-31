<?php get_header(); ?>
<?php
  $devType = getDevType();
  $category = get_category_by_path( $_SERVER['REQUEST_URI'], false );
  $posts = get_posts(array(
    'numberposts'   => 12,
    'cat'           => $category->cat_ID,
  ));
?>
<!-- Page Content -->
<div id="category" class="<?php echo getDevType() . " {$category->slug}"; ?> container">
    <div class="row no-gutters">
        <!-- Blog Entries Column -->
        <div class="col-sm col-12">
            <!-- Title -->
            <h5 class="title-sidebar">
              <?php echo $category->name; ?>
            </h5>
            <!-- MID POSTS -->
            <div id="" class="mid_post row no-gutters">
              <?php
                foreach ( $posts as $num => $item ){
                  $thumb = get_post_meta( $item->ID, 'thumb', true );
                  $img = get_the_post_thumbnail_url( $item->ID, 'medium' );

                  printf(
                    '<div class="item col-6 col-lg-4" data-thumb="%5$s" data-img="%6$s">
                      <a href="%1$s" class="link_post_small">
                        <div class="small-post">
                          <div class="post_news_small">
                            <div class="cover_img img2" style="background-image:url(%2$s);"></div>
                          </div>
                        </div>
                      </a>
                    </div>',
                    get_permalink( $item->ID ),
                    strlen( $thumb )?( get_template_directory_uri() . "/joomla_import/" . $thumb ):( $img ),
                    '',
                    '',
                    $thumb,
                    $img
                  );
                }
              ?>
              </button>
            </div>
            <?php if ( count($posts) == 12 ): ?>
              <button id="btn_more" type="button" name="button" class="col-12 fp-btn btn-more fw-bold position-relative" data-cmd="posts">
                <div class="spinner position-absolute">
                  <div class="box position-absolute"> </div>
                </div>
                Załaduj więcej
              </button>
            <?php endif; ?>
            <!-- /row-->
            <!-- /before content -->
        </div>
        <!-- / col -->
        <!-- Sidebar Column -->
        <div class="col-md-4 sidebar-list">
          <div class="sidebar row no-gutters d-md-block justify-content-center">
            <div class="col-12 col-sm-6 col-md">
              <?php echo printAd('v-l'); ?>
            </div>
          </div>
          <div class="sidebar position-sticky row no-gutters d-md-block justify-content-center">
            <?php get_template_part('template/sidebar-nadchodzace-desktop'); ?>
          </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
<?php get_footer(); ?>
