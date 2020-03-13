  <!-- Footer -->
  <footer class=" bg-footer">

    <div class="foot-content">
      <div class="container">

        <div class="logo_menu">

          <div class="logo mr-auto">
              <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri() . "/" ?>images/logo_nowy_targ.svg" onerror="this.onerror=null; this.src='<?php echo get_template_directory_uri() . "/" ?>images/logo_nowy_targ.png'" alt="Logo Nowy Targ 24 tv">
              </a>
            </div>

          <ul class="menu">
            <?php
            foreach ( wp_get_nav_menu_items('dolne-menu') as $item ){
              printf(
                '<li>
                  <a class="red-link" href="%1$s">
                    %2$s
                  </a>
                </li>',
                $item->url,
                $item->title
              );
            }
            ?>
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
  <?php wp_footer(); ?>
</body>
</html>
