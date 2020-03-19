<!-- Sidebar Column -->
<div id="single_sidebar_bot" class="single-post sidebar-list row no-gutters col-12 col-lg-4 d-lg-block">
  <!-- <div class="reklama-sidebar">
    <div class="reklama">Reklama 400x700px</div>
  </div> -->
  <div class="col-12 col-sm-4 col-lg-12 order-0 order-sm-2 order-lg-0">
    <?php echo printAd('pionowa'); ?>
  </div>
  <div class="reportaze sticky col-12 col-sm-8 col-lg-12">
    <?php
      $items = get_posts(array(
        'numberposts'   => 5,
        'category_name' => 'bedzie-sie-dzialo',
      ));
    ?>
    <h5 class="title-sidebar line">Będzie się działo</h5>

    <ul class="image-sidebar-section">

      <!-- single post -->
      <?php
        foreach ($items as $item) {
          printf(
            '<a href="%1$s">
              <li>
                <div class="image-container">
                  <div class="image" style="background-image:url(%2$s)"></div>
                </div>
                <span>%3$s</span>
              </li>
            </a>',
            get_permalink( $item->ID ),
            get_the_post_thumbnail_url( $item->ID, 'thumbnail' ),
            $item->post_title
          );
        }
      ?>

    </ul>

  </div>
  <!-- /Będzie się działo-->


</div>
<!-- /.row -->
