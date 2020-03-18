$(function(){

  // obsługa przycisku ładowania kolejnych wpisów w kategorii
  $('#category #btn_more')
  .on({
    click: function(e){
      let items = $('#category #tiles').children('.tile');
      let start = items.length + 1;
      let end = start + 12;

      $(this).addClass('loading');

      $.ajax({
        type: 'GET',
        url: '/api?cmd=posts&from='+start+'&to='+end,
        success: function( data, status, xhr ) {
          let posts = JSON.parse( data );
          // console.log( [ status, posts ] );

          if ( posts.length < 12 ) {
            $('#btn_more').hide();
          }

          posts.splice( 0, 12 ).forEach( (item)=>{
            // console.log( [item] );
            let t = items.last().clone();
            t.children('a').attr( 'href', item.url );
            t.find('.cover_img')
            .css( 'background-image', 'url('+item.img+')' );
            t.find('.small-post > span').html( item.title.replace( /\\/g, '' ) );
            $('#btn_more').before( t );
          } );

        },
        error: function( xhr, status, error ){

        },
        complete: function( xhr, status ){
          $('#category #btn_more').removeClass('loading');

        },

      });

    },
  });

  // obsługa przycisku ładowania kolejnych wpisów w wyszukiwarce
  $('#search #btn_more')
  .on({
    click: function(e){
      let items = $('#search .tiles').children('.tile');
      let start = items.length;
      let end = start + 12;

      $(this).addClass('loading');

      $.ajax({
        type: 'GET',
        url: '/api?cmd=search&from='+start+'&to='+end+'&q='+window.location.search.match(/q\=([^+]+)/)[1],
        success: function( data, status, xhr ){
          let posts = JSON.parse( data );
          // console.log( [ status, posts ] );

          if ( posts.length < 12 ) {
            $('#btn_more').hide();
          }

          posts.splice( 0, 12 ).forEach( (item)=>{
            // console.log( [item] );

            let t = items.last().clone();
            t.attr( 'href', item.url );
            if ( item.img !== false ){
              t.find('.img')
              .css( 'background-image', 'url('+item.img+')' );
            }
            t.find('.title').text( item.title.replace( /\\/g, '' ) );
            $('#search #btn_more').before( t );
          } );

        },
        error: function( xhr, status, error ){

        },
        complete: function( xhr, status ){
          $('#search #btn_more').removeClass('loading');

        },

      });

    },
  });

  // dymek do przycisku kopiowania adresu
  (function(btn){
    var oldTitle = btn.attr('title');

    btn
    .tooltip()
    .click(function(e){
      e.preventDefault();

      const el = document.createElement('textarea');
      el.value = window.location.href;
      document.body.appendChild(el);
      el.select();
      document.execCommand('copy');
      document.body.removeChild(el);

      btn
      .attr('title','Skopiowano!')
      .tooltip('dispose')
      .tooltip('show');

      setTimeout(function () {
        btn
        .attr( 'title', oldTitle )
        .tooltip( 'dispose' )
        .tooltip();

      }, 3000);
    })
  })
  (
    $('#post .clipboard')
  );

  // generowanie galerii unitegallery
  $('[id^="UGallery_"]').each(function(){
    $(this)
    .unitegallery({
      gallery_theme: "tiles",
			// tiles_type: "nested",
      lightbox_type: 'compact',
      tile_overlay_color: '#e3000f',
      tiles_col_width: 150,
    });

  });

  // generowanie galerii slick
  (function( gallery, items, nav, dots ){
    items
    .slick({
      arrows: true,
      appendArrows: nav,
      prevArrow: "<img class='arrow prev' src='/wp-content/themes/NT24TV/images/chevron-left.svg'/>",
      nextArrow: "<img class='arrow next' src='/wp-content/themes/NT24TV/images/chevron-right.svg'/>",
      dots: true,
      appendDots: dots,
      rows: 3,
      slidesToScroll: 4,
      slidesToShow: 4,
      responsive: [
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 425,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 375,
          settings: {
            slidesToShow: 2,
          }
        },
      ]
    });

  })(
    $('.slickGallery'),
    $('.slickGallery .items'),
    $('.slickGallery .nav'),
    $('.slickGallery .dots')
  )

});
