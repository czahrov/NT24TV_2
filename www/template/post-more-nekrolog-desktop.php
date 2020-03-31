<!-- post_more_nekrolog_desktop -->
<?php
  global $post_categories;
  $category = get_category( $post_categories[0] );
?>
<!-- post_more_desktop -->
<div class="clear-top"></div>
<h5 class="title-sidebar">Zobacz również</h5>
<div id='more' class="">
  <div class="mid_post row no-gutters">
    <?php
      $items = get_posts(array(
        'numberposts'   => 12,
        'exclude'       => array( get_the_ID() ),
        'orderby'       => 'random',
        'category'      => $category->cat_ID,
      ));
    ?>
    <!-- post -->
    <?php
    foreach ($items as $item) {
      printf(
        '<div class="item col-6 col-md-4 col-lg-3">
          <a href="%1$s" class="link_post_small">
            <div class="small-post">
              <div class="post_news_small">
                <div class="cover_img img2" style="background-image:url(%2$s)"></div>
              </div>
            </div>
          </a>
        </div>',
        get_permalink( $item->ID ),
        get_the_post_thumbnail_url( $item->ID, 'medium' )
      );
    }
    ?>
  </div>
  <button id="btn_more" class="col-12 fp-btn btn-more fw-bold position-relative" type="button" name="button" data-cmd="posts" data-category="<?php echo $category->slug ?>">
    <div class="spinner position-absolute">
      <div class="box position-absolute"> </div>
    </div>
    Załaduj więcej
  </button>
</div>
<!-- /row-->
