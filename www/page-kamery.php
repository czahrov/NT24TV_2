<?php
  /*Template Name: Strona główna*/
?>
<?php
  get_header();
  the_post();
  $kamery = get_posts( array(
		'category_name' => 'kamera-online',
		'orderby' => 'date',
		'order' => 'ASC',

	) );
?>
<div id="page" class="">
  <div class="container-fluid">
    <div class="row">
      <div class="banner position-relative col-12" style="background-image:url(<?php echo get_template_directory_uri() . "/images/kamery.jpg" ?>);">
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row no-gutters">
      <div class="content col-12 col-lg-9">
        <div id="kamery" class="row no-gutters align-items-start jutify-content-center">
          <?php
          foreach( $kamery as $item ):
            // $title = get_post_meta( $item->ID, 'title', true );
            // $typ = get_post_meta( $item->ID, 'typ', true );
            $title = get_post_field( 'title', $item->ID );
            $typ = get_post_field( 'typ', $item->ID );
            if( $typ === 'ipcamlive' ):
              $alias = get_post_meta( $item->ID, 'alias', true );
              ?>
              <div class='item col-12 col-md-6 col-xl-4 d-flex flex-column'>
                <iframe class='' src="//ipcamlive.com/player/player.php?alias=<?php echo $alias; ?>" frameborder="0" allowfullscreen></iframe>
                <div class='title text-center d-flex align-items-center justify-content-center'>
                  <div class='icon fa fa-play-circle'></div>
                  <div class='text fw-bold'><?php echo $title; ?></div>

                </div>

              </div>
              <?php
            else:
              // $img = wp_get_attachment_image_url( get_post_meta( $item->ID, 'img', true ), 'full' );
              // $uri = get_post_meta( $item->ID, 'uri', true );
              $img = wp_get_attachment_image_url( get_post_field( 'img', $item->ID ), 'full' );
              $uri = get_post_field( 'uri', $item->ID );
              ?>
              <a class='item col-12 col-md-6 col-xl-4 d-flex flex-column' href='<?php echo $uri; ?>' target='_blank'>
                <?php if( !empty( $img ) ): ?>
                  <div class='img' style='background-image:url(<?php echo $img; ?>);'>
                    <div class='wrapper'></div>
                  </div>
                <?php endif; ?>
                <div class='title text-center d-flex align-items-center justify-content-center'>
                  <div class='icon fa fa-play-circle'></div>
                  <div class='text fw-bold'><?php echo $title; ?></div>

                </div>

              </a>
            <?php endif; ?>
          <?php endforeach; ?>
          <?php the_content(); ?>
        </div>
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
