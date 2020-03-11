<?php
  /*Template Name: Strona główna*/
?>
<?php get_header(); ?>
<?php
  get_template_part( 'template/home/aktualnosci' );
  get_template_part( 'template/home/przeglad-tygodniowy' );
  get_template_part( 'template/home/sport' );
  get_template_part( 'template/home/popularne' );
  get_template_part( 'template/home/wskrocie' );
  get_template_part( 'template/home/sponsorowane' );
?>
<?php get_footer(); ?>
