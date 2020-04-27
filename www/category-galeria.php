<?php get_header(); ?>
<?php
  global $fp;
  $category = get_category_by_path( $_SERVER['REQUEST_URI'], false );
  $posts = get_posts(array(
    // 'numberposts'   => 13,
    'cat'           => $category->cat_ID,
  ));
?>
<!-- Page Content -->
<div id="category" class="<?php echo getDevType() . " {$category->slug}"; ?> container">
  <div class="row">
    <div class="col">
      <h5 class="title-sidebar">
        Galeria zdjęć
      </h5>
    </div>
  </div>
  <div class="row no-gutters">
    <div class="col-12 col-sm">
      <?php if ( !empty( $posts ) ): ?>
        <!-- MID POSTS -->
        <div class="mid_post row no-gutters">
        <?php foreach ($posts as $post){
          $galleries = fetchPostGalleries( $post->post_content );
          // var_dump( $galleries );
          if( empty( $galleries ) ) continue;

          $img = wp_get_attachment_image_url( $galleries[0][0], 'medium' );
          $photo_num = array_sum( array_map( function($g){
            return count( $g );
          }, $galleries ) );

          printf(
            '<div class="item col-6 col-md-4 col-lg-3" data-img="%s">
              <a href="%s" class="link_post_small">
                <div class="small-post">
                  <div class="post_news_small">
                    <div class="cover_img" style="background-image:url(%1$s);">
                      <div class="counter">
                        <img src="%s/images/camera.svg"/>
                        %s
                      </div>
                    </div>
                  </div>
                  <span>%s</span>
                </div>
              </a>
            </div>',
            $img,
            get_permalink( $item->ID ),
            get_template_directory_uri(),
            $photo_num,
            $post->post_title
          );
        } ?>
        </div>
      <?php else: ?>
        <div class="noposts text-center text-uppercase fw-bold">
          Nie dodano jeszcze żadnych galerii do wyświetlenia :(
        </div>
      <?php endif; ?>
    </div>
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
