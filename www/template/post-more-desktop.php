<!-- post_more_desktop -->
<?php
  global $post_categories;
  $category = get_category( $post_categories[0] );
?>
<div class="clear-top"></div>
<h5 class="title-sidebar">Zobacz również</h5>
<div id='more' class="row no-gutters padding">
  <!-- post -->
  <?php
    foreach ( getPostMore() as $item ) {
      if ( DBG ) {
        echo "<div id='more_dbg' style='display:none;'><!--";
        print_r( $item );
        echo "--></div>";
      }
      printPost( $item, 'mid', array( 'img_size' => 'thumbnail' ) );
    }
  ?>
</div>
<!-- /row-->
