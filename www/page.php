<?php
  /*Template Name: Strona główna*/
?>
<?php
  get_header();
  the_post();
  // $thumb = get_the_post_thumbnail_url( get_the_ID(), 'full' );
  // $bgimg = !$thumb?( get_template_directory_uri() . "/images/page.jpg" ):( $thumb );
?>
<div id="page" class="">
  <div class="container">
    <div class="row no-gutters">
      <div class="content padding col-12 col-lg-9">
        <?php the_content(); ?>
      </div>
      <div class=" col-12 col-lg-3">
        <div id="sidebar" class="position-sticky">
          <?php printAd( 'v-l' ); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
