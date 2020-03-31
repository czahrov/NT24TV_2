<?php
  /*Template Name: Strona główna*/
?>
<?php get_header(); ?>
<?php
  $spec_cats = get_terms(array(
    'taxonomy' => 'category',
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key' => 'front',
        'value' => 1
      ),
    ),
    'orderby' => 'term_id',
    'order' => 'DESC',
  ));

  global $cat;
  foreach ($spec_cats as $cat ) {
    get_template_part( sprintf(
      'template/home-special-%s',
      getDevType()
    ));
    // print_r( $scat );
    // print_r( get_term_meta( $scat->term_id ) );
  }
  unset( $cat );

  global $devType;
  $files = array(
    'template/home-aktualnosci-%s',
    'template/home-przeglad-%s',
    'template/home-sport-%s',
    'template/home-popularne-%s',
    'template/home-wskrocie-%s',
    'template/home-sponsorowane-%s',
  );

  array_map( function($arg){
    get_template_part( sprintf(
      $arg,
      getDevType()
      ) );
  }, $files );
?>
<?php get_footer(); ?>
