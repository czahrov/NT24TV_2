<?php /* Template Name: test */ ?>
<?php //get_header(); ?>
<?php
  global $fp;
  $path_to_dir = 'images/galerie/2017/2017.06.23.przywitanielata';

  $abs_path_to_joomla = get_template_directory() . '/joomla_import/' . $path_to_dir;
  $rel_path_to_joomla = get_template_directory_uri() . '/joomla_import/' . $path_to_dir;
  $files = array_slice( scandir( $abs_path_to_joomla ), 2 );
  $files = array_filter( $files, function( $arg ) use ($abs_path_to_joomla){
    $file_path = "{$abs_path_to_joomla}/{$arg}";
    // echo $file_path . PHP_EOL;
    preg_match( '~(\d+x\d+)|(\.orig$)~', $arg, $found );
    if ( !empty( $found[0] ) ) {
      return false;
    }
    else {
      if( in_array( strtolower( pathinfo( $arg, PATHINFO_EXTENSION ) ), array( 'jpg', 'jpeg', 'png', 'bmp' ) ) && file_exists( $file_path ) ){
        return true;
      }
      else{
        return false;
      }

    }

  });
  $files = array_map( function( $arg ) use ($rel_path_to_joomla){
    return sprintf(
      '%s/%s',
      $rel_path_to_joomla,
      $arg
    );
  }, $files );
  // var_dump(array(
  //   'cwd' => getcwd(),
  //   '$path_to_dir' => $path_to_dir,
  //   '$abs_path_to_joomla' => $abs_path_to_joomla,
  //   '$rel_path_to_joomla' => $rel_path_to_joomla,
  //   '$files' => $files,
  // ));
?>
<?php //get_footer(); ?>
