<!-- Sidebar Column -->
<div id="single_sidebar_top" class="single-post sidebar-list row no-gutters col-12 col-lg-4 d-lg-block">
  <!-- <div class="reklama-sidebar">
    <div class="reklama">Reklama 400x700px</div>
  </div> -->
  <div class="col-12 col-sm-4 col-lg-12 order-0 order-sm-2 order-lg-0">
    <div class="position-sticky">
      <?php echo printAd( 'v-l' ); ?>
    </div>
  </div>
  <div class="reportaze sticky col-12 col-sm-8 col-lg-12">
    <h5 class="title-sidebar line">Najbardziej popularne</h5>
    <ul class="image-sidebar-section">
      <?php
      $con = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
      $sql = "Select
      nttv_posts.ID
      From
      nttv_post_views Inner Join
      nttv_posts On nttv_posts.ID = nttv_post_views.id
      Where
      nttv_post_views.period = 'total' And
      nttv_posts.post_type = 'post'
      Order By
      nttv_post_views.count Desc
      Limit 5";
      $query = mysqli_query( $con, $sql );
      $res = mysqli_fetch_all( $query, MYSQLI_ASSOC );
      $ids = array_map( function( $arg ){
        return $arg['ID'];
      }, $res );
      mysqli_free_result( $res );
      mysqli_close( $con );

      $items = get_posts(array(
        'include' => $ids,
      ));
      ?>
      <!-- single post -->
      <?php
      foreach ($items as $item) {
        printf(
          '<a href="%1$s">
          <li>
          <div class="image-container">
          <div class="image pop_1" style="background-image:url(%2$s)"></div>
          </div>
          <span>%3$s</span>
          </li>
          </a>',
          get_permalink( $item),
          get_the_post_thumbnail_url( $item->ID, 'thumbnail' ),
          $item->post_title
        );
      }
      ?>

    </ul>

  </div>
  <!-- /Najbardziej popularne-->

</div>
