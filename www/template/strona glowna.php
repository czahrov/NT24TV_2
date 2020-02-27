<?php
  /*Template Name: Strona główna*/
?>
<?php
  require_once( get_template_directory() . '/header.php');
  include( get_template_directory() . '/template/home/aktualnosci.php' );
  include( get_template_directory() . '/template/home/przeglad-tygodniowy.php' );
  include( get_template_directory() . '/template/home/sport.php' );
  include( get_template_directory() . '/template/home/popularne.php' );
  include( get_template_directory() . '/template/home/wskrocie.php' );
  include( get_template_directory() . '/template/home/sponsorowane.php' );
  require_once( get_template_directory() . '/footer.php' );
?>
