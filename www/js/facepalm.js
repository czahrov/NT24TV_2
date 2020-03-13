$(function(){

  $('#category #btn_more')
  .on({
    click: function(e){
      let items = $('#category #tiles').children('.tile');
      let start = items.length;
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
            .css( 'background-image', 'url('+item.img+')' )
            .after( item.hot );
            t.find('.small-post > span').text( item.title.replace( /\\/g, '' ) );
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
            if ( item.img !== false ) t.find('.img')
            .css( 'background-image', 'url('+item.img+')' );
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

});
