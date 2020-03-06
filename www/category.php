<?php get_header(); ?>
<?php
  $category = get_category_by_path( $_SERVER['REQUEST_URI'], false );
  $posts = get_posts(array(
    'numberposts'   => 22,
    'cat'           => $category->cat_ID,
  ));
?>
<!-- Page Content -->
<div id="category" class="container">
    <!-- <?php
      print_r( $category );
      print_r( $posts );
    ?> -->
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
                            <div class="tags"></div>
                            <span class="tag">przed chwilą</span>
                            <span>%3$s</span>
                        </div>
                    </div>
                </a>',
                get_permalink( $item->ID ),
                get_the_post_thumbnail_url( $item->ID, 'full' ),
                $item->post_title
              );
            ?>
            <div class="clear-top"></div>
            <div class="row no-gutters">
              <?php
                foreach ( array_slice( $posts, 1 ) as $item) {
                  printf(
                    '<div class="col-sm col-6 col-lg-4">
                      <a href="%1$s" class="link_post_small">
                        <div class="small-post">
                          <div class="post_news_small">
                            <div class="cover_img img2" style="background-image:url(%2$s);"></div>
                          </div>
                          <span>%3$s</span>
                        </div>
                      </a>
                    </div>',
                    get_permalink( $item->ID ),
                    get_the_post_thumbnail_url( $item->ID, 'large' ),
                    $item->post_title
                  );
                }
              ?>

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
            <div class="reklama-sidebar  sticky">
                    <div class="reklama">Reklama 400x700px</div>
                </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
<?php get_footer(); ?>
