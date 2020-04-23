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
    <div class="row no-gutters">
      <div class="col-12 col-sm">
        <?php if ( !empty( $posts ) ): ?>
          <?php foreach ($posts as $post): ?>
            <?php
              $gallery = fetchFilebirdGallery( $post->post_content );
              // print_r( $gallery );
              // if( !empty( $gallery ) ):
              if( empty($gallery) ) continue;
            ?>
            <h5 class="title-sidebar">
              <?php echo $post->post_title; ?>
            </h5>
            <!-- MID POSTS -->
            <div class="mid_post row no-gutters">
              <?php $fp->printUGallery( $gallery ); ?>
            </div>
          <?php endforeach; ?>
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
