<!-- Sidebar Column -->
<div class="col-xl-4 col-sm-12 col-md-12 col-lg-12 single-post sidebar-list">


  <div class="reklama-sidebar">
    <div class="reklama">Reklama 400x700px</div>
  </div>

  <div class="reportaze  sticky">
    <h5 class="title-sidebar line">Najbardziej popularne</h5>


    <ul class="image-sidebar-section">
      <?php
        $items = get_posts(array(
          'numberposts' => 4,
          'orderby'     => 'post_views',
          'order'       => 'DESC',
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
