<?php
  /*Template Name: Strona główna*/
?>
<?php get_header(); ?>
<?php
  global $devType;
  $files = array(
    'template/%s/home/aktualnosci',
    'template/%s/home/przeglad-tygodniowy',
    'template/%s/home/sport',
    'template/%s/home/popularne',
    'template/%s/home/wskrocie',
    'template/%s/home/sponsorowane',
  );

  array_map( function($arg){
    get_template_part( sprintf(
      $arg,
      getDevType()
      ) );
  }, $files );
?>
<?php get_footer(); ?>
