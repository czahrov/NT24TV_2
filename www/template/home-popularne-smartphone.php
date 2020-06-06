<?php
  $category = get_category(112);
  $posts_limit = 4;
  $items = get_posts( array(
    'numberposts'     => $posts_limit,
    'cat'             => $category->cat_ID,
    'orderby'         => 'date',
    'order'           => 'DESC',
  ) );
?>
<!-- Page Content -->
<div id='popularne' class="<?php echo getDevType(); ?> container">

  <div class="row no-gutters">

    <!-- Blog Entries Column -->
    <div class="col-md-12">
      <h5 class="title-sidebar"><?php echo $category->name; ?></h5>
      <!-- Post -->
      <div class="slick row no-gutters najbardziej-popularne">
        <!-- single post -->
        <?php
          foreach ($items as $item) {
            printPost( $item, 'large', array( 'class' => 'no-padding' ) );
          }
          echo '<div class="col-12 col-md-6 no-padding">
            <div class="link_post_small" data-post-type="large" title="">
              <div class="small-post popular-post">
                <div class="post_news_small"></div>';
                printAd( 'v-l', false, array( 'class' => '' ) );
        echo '</div>
            </div>
          </div>';
        ?>

      </div>
      <div class="arrows d-flex justify-content-between"> </div>
    </div>
    <!-- /col-8 -->

  </div>
  <!-- /.row -->

</div>
<!-- /.container -->
<div class="clear-top"></div>
