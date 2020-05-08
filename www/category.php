<?php get_header(); ?>
<?php
  $category = get_category_by_path( $_SERVER['REQUEST_URI'], false );
  $post_limit = getDevType() == 'smartphone'?(15):(16);
  $posts = get_posts(array(
    'numberposts'   => $post_limit,
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
              printPost( $posts[0], 'big', array( 'class'=> 'no-padding col-lg-12' ) );
            ?>
            <div class="clear-top"></div>
            <!-- MID POSTS -->
            <div class="mid_post row no-gutters">
              <?php
                foreach ( array_slice( $posts, 1, 24 ) as $num => $item ){
                  printPost( $item, 'mid', array( 'class'=> 'item' ) );
                }
              ?>
            </div>
            <?php if ( count($posts) == $post_limit ): ?>
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
