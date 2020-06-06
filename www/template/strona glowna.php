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
    templateLoader('template/home-special-%s');
  }
  unset( $cat );

  global $devType;
  // lista plików z szablonami
  $files = array(
    'template/home-aktualnosci-%s',
    'template/home-przeglad-%s',
    'template/home-sport-%s',
    'template/home-chicago-%s',
    'template/home-popularne-%s',
    'template/home-wskrocie-%s',
    'template/home-sponsorowane-%s',
  );

  // ładowanie szablonów
  templateLoader( $files );
  // array_map( function($arg){
  //   $types = array( 'desktop', 'tablet', 'smartphone' );
  //   $file_url = sprintf(
  //     $arg,
  //     getDevType()
  //   );
  //   get_template_part( $file_url );
  // }, $files );
?>
<?php get_footer(); ?>
