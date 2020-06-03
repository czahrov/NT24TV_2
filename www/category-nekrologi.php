<?php get_header(); ?>
<?php
  $devType = getDevType();
  preg_match( '~^([^\?]+)~', $_SERVER['REQUEST_URI'], $match );
  $category = get_category_by_path( $match[1], false );
  $post_limit = 12;
  $posts = get_posts(array(
    'numberposts'   => $post_limit,
    'cat'           => $category->cat_ID,
  ));
?>
<!-- Page Content -->
<div id="category" class="<?php echo getDevType() . " {$category->slug}"; ?> container padding-md">
  <div class="row no-gutters">
      <!-- Blog Entries Column -->
      <div class="col-12 col-sm">
        <!-- Title -->
        <h5 class="title-sidebar">
          <?php echo $category->name; ?>
        </h5>
        <?php if ( !empty( $posts) ): ?>
          <div class="items row no-gutters">
            <!-- MID POSTS -->
            <?php
              foreach ( $posts as $num => $item ){
                printPost( $item, 'mid', array( 'class'=> 'item' ) );
              }
            ?>
            <?php if ( count($posts) == $post_limit ): ?>
              <button id="btn_more" class="col-12 fp-btn btn-more fw-bold position-relative" type="button" name="button" data-cmd="posts" data-category="<?php echo $category->slug; ?>">
                <div class="spinner position-absolute">
                  <div class="box position-absolute"> </div>
                </div>
                Załaduj więcej
              </button>
            <?php endif; ?>
            <!-- /row-->
          </div>
          <!-- /before content -->
        <?php else: ?>
          <div class="noposts text-center text-uppercase fw-bold">
            Ta kategoria nie posiada jeszcze wpisów do wyświetlenia :(
          </div>
        <?php endif; ?>

      </div>
      <!-- / col -->
      <!-- Sidebar Column -->
      <div class="sidebar sidebar-list col-12 col-lg-4 row no-gutters padding-lg d-lg-block">
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
