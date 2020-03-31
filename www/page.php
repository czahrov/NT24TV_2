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
      <div class="content padding col-12 col-lg-8">
        <?php the_content(); ?>
      </div>
      <div class="sidebar col-12 col-lg-4 row no-gutters padding-lg d-lg-block">
        <div class="col-12 col-sm col-lg-12">
          <?php echo printAd('v-l'); ?>
        </div>
        <div class="position-sticky col-12 col-sm-7 col-md-8 col-lg-12">
          <?php get_template_part('template/sidebar-nadchodzace-desktop'); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
