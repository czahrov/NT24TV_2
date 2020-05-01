<?php
  $items = get_posts(array(
    'numberposts'     => 4,
    'category_name'   => 'przeglad-tygodniowy',
  ));
?>
<!-- Page Content -->
<div id='przeglad_tygodniowy' class="<?php echo getDevType(); ?> container">
  <div class="row no-gutters">
    <!-- Blog Entries Column -->
    <div class="col-md-6 col-lg-8">
      <a href="<?php echo get_category_link( get_category_by_slug( 'przeglad-tygodniowy' )->cat_ID ); ?>">
        <h5 class="title-sidebar">Przegląd tygodniowy</h5>
      </a>
      <!-- BIG Post -->
      <?php
        printPost( $items[0], 'big' );
      ?>

      <div class="clear-top"></div>

      <div class="row no-gutters">

        <!-- MID post -->
        <?php
          foreach ( array_slice( $items, 1 ) as $item ) {
            printPost( $item, 'mid' );
          }
        ?>

      </div>
      <!-- /row-->
      <div class="clear-top"></div>
      <div class="button-line">
        <a href="<?php echo get_category_link( get_category_by_slug( 'przeglad-tygodniowy' )->cat_ID ); ?>" class="">Więcej Przeglądów</a>
      </div>

      <!-- reklama pozioma -->
      <?php echo printAd('h-m'); ?>
      <!-- <div class="reklama-full-page">
        <div class="reklama">Reklama 840x150px</div>
      </div> -->

    </div>
    <!-- /col-8 -->
    <!-- Sidebar Column -->
    <div class="col-sm-12 col-md-6 col-lg-4 sidebar-list">
      <a href="<?php echo get_permalink( get_page_by_title( 'Pogoda' )->ID ); ?>">
        <h5 class="title-sidebar">Stan powietrza Nowy Targ</h5>
      </a>
      <?php get_template_part('template/airly'); ?>

      <div class="clear-top"></div>
      <div class="position-sticky">
        <?php get_template_part('template/sidebar-reportaze-desktop'); ?>
      </div>
      <!-- /reportaże -->

    </div>
  </div>
  <!-- /.row -->

</div>
<!-- /.container -->
<div class="clear-top"></div>
