<?php
  $toDisplay = get_post_meta( get_the_id(), 'oferty_sponsorowane', true ) == 1;
  if( $toDisplay ):
?>
  <!-- Oferty sponsorowane-->
  <div class="container">

    <div class="row no-gutters oferty-sponsorowane">

      <!-- Blog Entries Column -->
      <div class="col-lg-12 col-xl-8 col-sm-12 col-md-12">

        <h5 class="title-sidebar line">Oferty sponsorowane</h5>

        <div class="clear-top"></div>

        <div class="row no-gutters">
          <!-- post -->
          <div class="col-lg-12 col-xl-4 2 col-sm-12 col-md-12">
            <div class="reklama-pion-oferta">
              <div class="reklama">Reklama 260x600px</div>
            </div>

          </div>
          <!-- post -->
          <div class="col-lg-12 col-xl-4 col-sm-12 col-md-12">
            <div class="reklama-pion-oferta">
              <div class="reklama">Reklama 260x600px</div>
            </div>

          </div>

          <!-- post -->
          <div class="col-lg-12 col-xl-4 col-sm-12 col-md-12">

            <div class="reklama-pion-oferta">
              <div class="reklama">Reklama 260x600px</div>
            </div>


          </div>

          <div class="col-lg-12 col-xl-12 col-sm-12">

            <div class="reklama-poziom-oferta">
              <div class="reklama">Reklama 260x600px</div>
            </div>


          </div>

        </div>
        <!-- /row-->


      </div>
      <!-- /col-8 -->




      <!-- Sidebar Column -->
      <div class="col-sm-12 col-xl-4 col-md-12 col-lg-12 sidebar-list">

        <div class="reklama-oferta-sidebar">
          <div class="reklama">Reklama 400x700px</div>
        </div>

        <div class="reklama-oferta-sidebar">
          <div class="reklama">Reklama 400x700px</div>
        </div>

        <div class="reklama-oferta-sidebar">
          <div class="reklama">Reklama 400x700px</div>
        </div>

      </div>
    </div>
    <!-- /.row -->




  </div>
  <!-- /.container -->
<?php endif; ?>
