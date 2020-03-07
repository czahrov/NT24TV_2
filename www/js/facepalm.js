$(function(){

  $('#category #btn_more')
  .on({
    click: function(e){
      let items = $('#category #tiles').children('.tile');
      let start = items.length;
      let end = start + 12;
      $.get(
        '/api?cmd=posts&from='+start+'&to='+end,
        ( data, status )=>{
          let posts = JSON.parse( data );
          console.log( [ status, posts ] );

          if ( posts.length < 12 ) {
            $('#btn_more').hide();
          }

          posts.splice( 0, 12 ).forEach( (item)=>{
            let t = items.last().clone();
            t.children('a').attr( 'href', item.url );
            t.find('.cover_img').css( 'background-image', 'url('+item.img+')' );
            t.find('.small-post > span').text( item.title.replace( '\\', '' ) );
            $('#btn_more').before( t );
          } );
        }
      );

    },
  })

});
