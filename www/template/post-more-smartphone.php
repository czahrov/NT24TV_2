<div class="clear-top"></div>
<h5 class="title-sidebar">Zobacz również</h5>
<div id='more' class="row no-gutters">
  <?php
    $items = get_posts(array(
      'numberposts'   => 12,
      'exclude'       => array( get_the_ID() ),
      'orderby'       => 'random',
      'category'      => wp_get_post_categories( get_the_ID(), array( 'exclude' => array( 68, 111 ) ) )[0],
    ));
  ?>
  <!-- post -->
  <?php
    foreach ($items as $item) {
      printf(
        '<div class="col-6 col-lg-4">
          <a href="%s" class="link_post_small">
            <div class="small-post">
              <div class="post_news_small">
                <div class="cover_img" style="background-image:url(%s)"></div>
              </div>
              <span>%s %s</span>
            </div>
          </a>
        </div>',
        get_permalink( $item->ID ),
        get_the_post_thumbnail_url( $item->ID, 'medium' ),
        $item->post_title,
        printTags( $item->ID )
      );
    }
  ?>


</div>
<!-- /row-->
