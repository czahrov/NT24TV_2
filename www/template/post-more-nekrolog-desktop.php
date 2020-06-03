<!-- post_more_nekrolog_desktop -->
<?php
  global $post_categories;
  $category = get_category( $post_categories[0] );
?>
<!-- post_more_desktop -->
<div class="clear-top"></div>
<h5 class="title-sidebar">Zobacz również</h5>
<div id='more' class="">
  <div class="mid_post items row no-gutters">
    <?php
      $post_limit = 12;
      $items = get_posts(array(
        'numberposts'   => $post_limit,
        'exclude'       => array( get_the_ID() ),
        'orderby'       => 'random',
        'category'      => $category->cat_ID,
      ));
    ?>
    <!-- post -->
    <?php
      foreach ($items as $item) {
        printPost( $item, 'mid', array( 'class'=> 'item' ) );
      }
    ?>
    <?php if ( count($items) == $post_limit ): ?>
      <button id="btn_more" class="col-12 fp-btn btn-more fw-bold position-relative" type="button" name="button" data-cmd="posts" data-category="<?php echo $category->slug; ?>">
        <div class="spinner position-absolute">
          <div class="box position-absolute"> </div>
        </div>
        Załaduj więcej
      </button>
    <?php endif; ?>
  </div>
</div>
<!-- /row-->
