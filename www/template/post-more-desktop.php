<!-- post_more_desktop -->
<?php
  global $post_categories;
  $category = get_category( $post_categories[0] );
?>
<div class="clear-top"></div>
<h5 class="title-sidebar">Zobacz również</h5>
<div id='more' class="row no-gutters">
  <!-- post -->
  <?php
    foreach ( getPostMore() as $item ) {
      if ( DBG ) {
        echo "<!--";
        print_r( $item );
        echo "-->";
      }
      $img = get_the_post_thumbnail_url( $item->ID, 'medium' );
      if ( !$img ) {
        $img = sprintf(
          '%s/joomla_import/%s',
          get_template_directory_uri(),
          get_post_meta( $item->ID, 'thumb', true )
        );
      }
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
        $img,
        $item->post_title,
        printTags( $item->ID )
      );
    }
  ?>
</div>
<!-- /row-->
