<?php
  $toDisplay = get_post_meta(get_the_id(), 'oferty_sponsorowane', true) == 1;
  if ($toDisplay):
?>
<!-- Oferty sponsorowane-->
<div id="sponsorowane" class="container">

  <div class="row no-gutters oferty-sponsorowane">

    <!-- Blog Entries Column -->
    <div class="col-12 col-xl-8">
      <h5 class="title-sidebar line">Oferty sponsorowane</h5>
      <div class="clear-top"></div>
      <div class="row no-gutters">
        <?php for( $i=0; $i<3; $i++ ): ?>
          <div class="col-12 col-lg-4">
            <!-- reklama pionowa -->
            <?php printAd( 'v-l', true ); ?>
            <!-- <div class="reklama-pion-oferta">
              <div class="reklama">Reklama 260x600px</div>
            </div> -->
          </div>
        <?php endfor; ?>

        <?php for( $i=0; $i<2; $i++ ): ?>
          <div class="col-12 col-md-6">
            <!-- reklama pozioma -->
            <?php printAd( 'h-s', true ); ?>
            <!-- <div class="reklama-poziom-oferta">
              <div class="reklama">Reklama 260x600px</div>
            </div> -->
          </div>
        <?php endfor; ?>

      </div>
      <!-- /row-->

    </div>
    <!-- /col-8 -->

    <!-- Sidebar Column -->
    <div id='sidebar' class="sidebar-list col-12 col-xl-4 row no-gutters align-items-end justify-content-center">
      <?php for( $i=0; $i<3; $i++ ): ?>
        <div class="col-12 col-md-6 col-xl-12">
          <!-- reklama pozioma -->
          <?php printAd( 'h-s', true ); ?>
          <!-- <div class="reklama-oferta-sidebar">
            <div class="reklama">Reklama 400x700px</div>
          </div> -->
        </div>
      <?php endfor; ?>
    </div>
  </div>
  <!-- /.row -->

</div>
<!-- /.container -->
<?php endif; ?>
