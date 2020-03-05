<?php /* Template Name: test */ ?>
<?php
  $input = "https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00046-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00047-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00049-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00050-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00051-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00052-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00055-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00056-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00058-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00059-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00065-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00067-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00070-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00073-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00075-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00079-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00085-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00088-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00094-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00096-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00100-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00105-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00106-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00109-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00111-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00113-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00117-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00119-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00121-Large-rotated.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00122-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00125-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00127-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00129-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00131-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00133-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00135-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00138-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00139-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00141-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00142-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00144-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00146-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00148-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00150-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00153-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00154-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00155-Large.jpg
  https://nowytarg24.tv/wp-content/uploads/2020/02/DSC00157-Large.jpg";
  $urls = explode( "\n", $input );
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
      a.lazy{
        font-size: 0;
        display: inline-block;
        width: 300px;
        height: 300px;
        background-color: silver;
        background-position: center top;
        background-size: cover;
        background-repeat: no-repeat;
      }

      a.lazy img{
        display: none;
        max-width: 100%;
        max-height: 100%;
      }

    </style>
  </head>
  <body>
    <?php foreach ( $urls as $img ){
      printf(
        '<a class="lazy">
          <img src="" data-lazy="%1$s" data-lazyBg="url(%1$s)">
        </a>',
        trim($img)
      );
    }?>

    <script type="text/javascript" src="<?php echo get_template_directory_uri() . "/js/"; ?>jquery-3.1.1.min.js"></script>
    <script type="text/javascript">
      $(function(){

        $('.lazy')
        // .hide()
        .each(function(n,item){
          let img = $(this).children('img');

          $(this)
          .on({
            check: function(e){
              console.log('['+$(this).index()+'] check');
              if( $(this).position().top <= window.innerHeight + $('html, body').prop('scrollTop') ){
                $(this).triggerHandler('start');
              }

            },
            start: function(e){
              console.log('['+$(this).index()+'] start');
              $(this).off('check');

              img
              .on({
                load: function(e){
                  console.log('['+img.parent().index()+'] load!');

                  img
                  .parent()
                  .css({
                    backgroundImage: img.attr('data-lazyBg'),
                  })
                  .fadeIn('fast');;

                },
              })
              .attr({
                src: ()=>img.attr('data-lazy'),
              });

            },

          })
          .triggerHandler('check');

          $(window).scroll(function(e){
            console.log('scroll!');
            $(item).triggerHandler('check');

          });

        });

      });
    </script>
  </body>
</html>
