<?php get_header(); ?>
<?php
  $category = get_category_by_path( $_SERVER['REQUEST_URI'], false );
  $posts = get_posts(array(
    'numberposts'   => 13,
    'cat'           => $category->cat_ID,
  ));
?>
<!-- Page Content -->
<div id="category" class="container">
    <div class="row no-gutters">
        <!-- Blog Entries Column -->
        <div class="col-sm col-12">
            <!-- Title -->
            <h5 class="title-sidebar">
              <?php echo $category->name; ?>
            </h5>
            <!-- BIG POST -->
            <?php
              $item = $posts[0];
              printf(
                '<a class="link_post big " href="%1$s">
                    <div class="big-post">
                        <div class="cover_img img1"></div>
                        <div class="post_news_big" style="background-image:url(%2$s);">
                            <div class="tags">
                              %4$s
                            </div>
                            <span>%3$s</span>
                        </div>
                    </div>
                </a>',
                get_permalink( $item->ID ),
                get_the_post_thumbnail_url( $item->ID, 'full' ),
                $item->post_title,
                isFresh( $item->ID )
              );
            ?>
            <div class="clear-top"></div>
            <!-- MID POSTS -->
            <div id="tiles" class="row no-gutters">
              <?php
                $export = array();
                foreach ( array_slice( $posts, 14 ) as $num => $item ) {
                  $img = get_the_post_thumbnail_url( $item->ID, 'large' );
                  $permalink = get_permalink( $item->ID );
                  $title = addslashes( $item->post_title );
                  $export[] = array(
                    'title'   => $title,
                    'img'     => $img,
                    'url'     => $permalink,
                    'hot'     => isHot( $item->ID ),
                  );
                }
              ?>
              <script type="text/javascript">
                var postsExport = JSON.parse('<?php echo json_encode( $export ); ?>');
              </script>
              <?php
                foreach ( array_slice( $posts, 1, 24 ) as $num => $item ){
                  printf(
                    '<div class="tile col-12 col-sm-6 col-lg-4">
                      <a href="%1$s" class="link_post_small">
                        <div class="small-post">
                          <div class="post_news_small">
                            <div class="cover_img img2" style="background-image:url(%2$s);"></div>
                            %4$s
                          </div>
                          <span>%3$s</span>
                        </div>
                      </a>
                    </div>',
                    get_permalink( $item->ID ),
                    get_the_post_thumbnail_url( $item->ID, 'large' ),
                    $item->post_title,
                    isHot( $item->ID )
                  );
                }
              ?>
              <button id="btn_more" type="button" name="button" class="col-12 fp-btn btn-more fw-bold position-relative">
                <div class="spinner position-absolute">
                  <div class="box position-absolute"> </div>
                </div>
                Załaduj więcej
              </button>
            </div>
            <!-- /row-->
            <!-- /before content -->
        </div>
        <!-- / col -->
        <!-- Sidebar Column -->
        <div class="col-md-4 sidebar-list">
          <div class="reklama-sidebar">
              <div class="reklama">Reklama 400x700px</div>
          </div>
          <div class="reklama-sidebar sticky">
                    <div class="reklama">Reklama 400x700px</div>
                </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
<?php get_footer(); ?>
