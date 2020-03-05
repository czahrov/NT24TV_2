  <!-- Footer -->
  <footer class=" bg-footer">

    <div class="foot-content">
      <div class="container">

        <div class="logo_menu">

          <div class="logo mr-auto">
              <a href="index.php">
                <img src="<?php echo get_template_directory_uri() . "/" ?>images/logo_nowy_targ.svg" onerror="this.onerror=null; this.src='<?php echo get_template_directory_uri() . "/" ?>images/logo_nowy_targ.png'" alt="Logo Nowy Targ 24 tv">
              </a>
            </div>

          <ul class="menu">

            <li>
              <a class="red-link" href="#">Regulamin PPV</a>
            </li>
            <li>
              <a class="red-link" href="#">Polityka prywatności</a>
            </li>
            <li>
              <a class="red-link" href="#">Redakcja</a>
            </li>
            <li>
              <a class="red-link" href="#">Dział reklamy</a>
            </li>
            <li>
              <a class="red-link" href="#">Cennik</a>
            </li>
            <li>
              <a class="red-link" href="#">Oferty pracy</a>
            </li>

          </ul>

        </div>
        <!-- /logo_menu -->


        <div class="contact-info">
          <span>Informacje z Podhala</span>
          <a href="#">kontakt@nowytarg24.tv</a>
          <a href="#">tel. +48 500 044 960</a>
          <a href="#"> tel. 18 266 99 00</a>
        </div>

      </div>
    </div>

    <div class="copy">
      <div class="container">
        <div class="copy-content">
          <p class="m-0 text-center">&copy;2020 Nowotarska Telewizja Kablowa. ul. Józefczaka 1, 34-400 Nowy Targ </p>
          <span>Projekt i wykonanie:
            <a href="https://scepter.agency">Scepter Agencja Interaktywna</a>
          </span>
        </div>

      </div>
      <!-- /.container -->
    </div>


  </footer>

  <!-- Bootstrap core JavaScript -->
  <?php
    // wp_enqueue_script( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, bool $in_footer = false )
    wp_enqueue_script( 'jQuery', get_template_directory_uri().'/vendor/jquery/jquery.min.js', array(), false, true );
    wp_enqueue_script( 'bootsrap', get_template_directory_uri().'/vendor/bootstrap/js/bootstrap.bundle.min.js', array( 'jQuery' ), false, true );
    wp_enqueue_script( 'jQuery-slick', 'https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.min.js', array(), false, true );
    wp_enqueue_script( 'slick', get_template_directory_uri().'/vendor/jquery/slick.js', array( 'jQuery-slick' ), false, true );
  ?>
  <?php wp_footer(); ?>
</body>
</html>
