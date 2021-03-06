<?php
  get_header();
  the_post();
?>
<div id="page" class="padding-pogoda">
  <div class="container">
    <div class="row no-gutters">
      <div class="content col-12 col-lg-9">
        <?php get_template_part('template/airly','full') ?>
        <?php get_template_part('template/forecast') ?>
        <?php the_content(); ?>
      </div>
      <div class=" col-12 col-lg-3">
        <div id="sidebar" class="position-sticky">
          <?php printAd( 'v-l', false, array( 'class' => 'padding-md' ) ); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
