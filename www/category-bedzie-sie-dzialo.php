<?php get_header(); ?>
<?php
  preg_match( '~^([^\?]+)~', $_SERVER['REQUEST_URI'], $match );
  $category = get_category_by_path( $match[1], false );
  switch ( getDevType() ) {
    case 'smartphone':
      $post_limit = 13;
      break;
    case 'tablet':
      $post_limit = 20;
      break;
    case 'desktop':
      $post_limit = 17;
      break;
    default:
      // code...
      break;
  }
  $date_now = date( 'Y-m-d H:i' );
  $posts = get_posts(array(
    'numberposts'   => $post_limit,
    'cat'           => $category->cat_ID,
    'meta_query'     => array(
      'relation'  => 'AND',
      array(
        'key'     => 'event_start',
        'value'   => $date_now,
        'compare' => '<=',
      ),
      array(
        'key'     => 'event_end',
        'value'   => $date_now,
        'compare' => '>=',
      ),
    ),
  ));
  $posts_num = count( $posts );
?>
<!-- Page Content -->
<div id="category" class="<?php echo getDevType() . " {$category->slug}"; ?> container padding-md">
    <?php if (DBG): ?>
      <div class="debug _posts">
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
            <div class="items row no-gutters">
              <!-- BIG POST -->
              <?php
                printPost( array_splice( $posts, 0, 1 )[0], 'big', array( 'img_size' => 'medium', 'class'=> 'item' ) );
              ?>
              <!-- MID POSTS -->
              <?php
                foreach ( array_splice( $posts, 0, 24 ) as $num => $item ){
                  printPost( $item, 'mid', array( 'img_size' => 'thumbnail', 'class'=> 'item' ) );
                }
              ?>
              <?php if ( $posts_num == $post_limit ): ?>
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
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
<?php get_footer(); ?>
