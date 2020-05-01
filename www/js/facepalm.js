$(function(){

  // obsługa przycisku ładowania kolejnych wpisów w kategorii
  $('body #btn_more')
  .each(function(){
    let _ = $(this);
    _.on({
      click: function(e){
        let items = _.prevAll('.mid_post').find('.item');
        let root = items.first().parent();

        let query_parts = {
          cmd: ()=>{
            let val = _.attr('data-cmd');
            console.log( val );
            if ( val !== undefined ) {
              return val;
            }
            else {
              return false;
            }
          },
          cat: ()=>{
            let val = _.attr('data-category');
            if ( val !== undefined ) {
              return val;
            }
            else {
              return false;
            }
          },
          from: items.length + 1,
          to: items.length + 13,
          q: ()=>{
            let found = window.location.search.match(/q=([^&]+)/);
            if ( found !== null ) {
              return found[1];
            }
            else {
              return false;
            }
          },
        };

        let query = [];
        for(item in query_parts){
          ((name,value)=>{
            if ( typeof value === 'function' ) {
              if( value() !== false ){
                query.push( name+"="+value() );
              };
            }
            else{
              query.push( name+"="+value );
            }
          })(
            item,
            query_parts[item]
          );
        }

        let query_string = query.join('&');
        console.log( [query_parts, query, query_string] );

        $(this).addClass('loading');

        $.ajax({
          type: 'GET',
          url: '/api?' + query_string,
          success: function( data, status, xhr ) {
            let posts = JSON.parse( data );
            console.log( [ status, posts, xhr ] );

            if ( posts.length < 12 ){
              _.hide();
            }

            posts.splice( 0, 12 ).forEach( (item)=>{
              // console.log( [item] );
              let t = items.last().clone();
              t.find('a').attr( 'href', item.url );
              t.find('.cover_img')
              .css( 'background-image', 'url('+item.img+')' );
              t.find('.small-post > span').html( item.title.replace( /\\/g, '' ) );
              root.append(t);
              // $('#btn_more').before( t );
            } );

          },
          error: function( xhr, status, error ){
            console.error( [status, error] );
          },
          complete: function( xhr, status ){
            // console.log( [status, xhr] );
            _.removeClass('loading').blur();

          },

        });

      },
    });
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
      .attr('title','Skopiowano do schowka!')
      .tooltip('dispose')
      .tooltip('show');

      setTimeout(function () {
        btn
        .attr( 'title', oldTitle )
        .tooltip( 'dispose' )
        .tooltip();

      }, 3000);
    })
  })(
    $('#post .clipboard')
  );

  // generowanie galerii unitegallery
  $('[id^="UGallery_"]').each(function(){
    $(this)
    .unitegallery({
      gallery_theme: "tiles",
      tiles_type: "justified",
      // gallery_width: '100%',
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
  );

  // slider popularnych
  (function( slider, items, arrows ){
    let settings = {
      infinite: true,
      slidesToShow: 1,
      dots: false,
      arrows: true,
      appendArrows: arrows,
      prevArrow: "<img class='arrow prev' src='wp-content/themes/NT24TV/images/arrow.svg'/ alt='poprzedni'>",
      nextArrow: "<img class='arrow next' src='wp-content/themes/NT24TV/images/arrow.svg' alt='następny'/>",
      swipeToSlide: true,
    };

    $(window)
    .resize(function(){
      if ( window.innerWidth < 768 ) {
        if ( !slider.hasClass('slick-initialized' ) ) {
          // console.log('start');
          slider.slick(settings);
        }

      }
      else{
        if( slider.hasClass('slick-initialized' ) ){
          // console.log('stop');
          slider.slick('unslick');
        }
      }
    })
    .resize();

  })(
    $('#popularne .slick'),
    $('#popularne .slick .item'),
    $('#popularne .slick + .arrows')
  );

  // popup z wyszukiwarką
  (function(popup, oldForm, popupBtn){
    if ( !popup.length ) return;
    let newForm = oldForm.clone(true);

    let popupTL = new TimelineLite({
      paused: true,
      onStart: function(e){
        popup.addClass('show');
      },
      onComplete: function(e){
        popup.find('form input.form-control').focus();
      },
      onReverseComplete: function(e){
        popup.removeClass('show');
      },
    })
    .add(
      TweenLite.fromTo(
        popup,
        1,
        {
          opacity: 0,
        },
        {
          opacity: 1,
        }
      )
    )
    .add(
      TweenLite.fromTo(
        newForm,
        1,
        {
          y: -100,
          opacity: 0,
        },
        {
          y: 0,
          opacity: 1,
        }
      )
    )
    .totalDuration(0.3);

    popup
    .find('.box')
    .append( newForm );

    popup
    .on({
      open: function(e){
        popupTL.play();
      },
      close: function(e){
        popupTL.reverse();
      },
      click: function(e){
        popup.triggerHandler('close');
      },
    })
    .find('.box')
    .click(e => {
      e.stopPropagation();
    });

    popupBtn.click(e => {popup.triggerHandler('open')});

  })(
    $('#search-popup'),
    $('.head-menu .search-bar'),
    $('#bot-bar .button.search')
  );

  // obsługa filmików youtube
  (function( placeholder ){
    placeholder.each(function(){
      const _ = $(this);
      const root = _.parent();
      const vidId = _.attr('data-yt-video-id');
      const autoplay = _.attr('data-yt-video-autoplay');
      const controls = _.attr('data-yt-video-controls');
      const muted = _.attr('data-yt-video-muted');
      const allow_detach = _.attr('data-yt-video-detach');
      var player = null;
      var detached = false;
      const playerTop = root.offset().top;
      var playerHeight = null;
      const windowPos = ()=>{
        return $('html,body').prop('scrollTop')
      };
      const inView = ()=>{
        return (( windowPos() - playerTop + 30 ) <= playerHeight)&&( (windowPos() + window.innerHeight) >= playerTop );
      };
      var playerStatus = null;

      _.before( $('<script src="https://www.youtube.com/iframe_api"></script>') );

      window.onYouTubeIframeAPIReady = function(){
        player = new YT.Player( _[0], {
          videoId: vidId,
          width: '100%',
          height: '100%',
          playerVars:{
            // autoplay: 1,
            controls: controls,
            rel: 0,
            origin: window.location.origin,
            enablejsapi: 1,
          },
          events:{
            onReady: function(e){
              playerHeight = $(player.f).outerHeight();
              if ( muted == 1 ) {
                player.mute();
                root.find('.mute').fadeIn();
              }
              if ( autoplay == 1 && inView() ) {
                player.playVideo();
                console.log('play_onReady');
              }
            },
            onStateChange: function(e){
              if ( e.data == 0 ) {
                root.triggerHandler('attach');
              }
            },
          }
        } );
      };

      root.on({
        'getPlayer': function(e){
          return player;
        },
        'detach': function(e){
          if( typeof player == 'object' && player.getPlayerState() === 1 ){
            root.parents('body > [id]:first')
            .css({
              position: function(e){
                let current = $(this).css('position');
                return current == 'static'?('relative'):( current );
              },
              zIndex: 150,
            });
            $(this).addClass('mini');
            detached = true;
          }
        },
        'attach': function(e){
          root.parents('body > [id]:first').attr({
            'style': null,
          });
          $(this).removeClass('mini');
          playerHeight = $(this).outerHeight(true);
          detached = false;
        },
        'exit': function(e){
          player.pauseVideo();
          $(this).triggerHandler( 'attach' );
        },
      });

      $('body').keydown((e)=>{
        if ( e.code == 'Escape' ) {
          root.triggerHandler('exit');
        }
      });

      root.find('.exit').click((e)=>{root.triggerHandler('exit')});

      $(window).scroll(function(e){
        if( allow_detach == 1 ){
          if ( !inView()  && !detached ){
            root.triggerHandler('detach');
          }
          else if( inView() && detached ){
            root.triggerHandler('attach');
          }

          if ( playerStatus != 'play' && inView() && [-1,5].indexOf( player.getPlayerState() ) > 0 ) {
            player.playVideo();
            playerStatus = 'play';
            // console.log('play_scroll');
          }

        }

        if( playerStatus != 'pause' && !inView() && allow_detach !== 1 && [1].indexOf( player.getPlayerState() ) > 0 ){
          player.pauseVideo();
          playerStatus = 'pause';
          // console.log('pause_scroll');
        }

      });

    });

  })(
    $('.yt-video')
  );

  // przewijany pasek informacyjny
  (function( pasek, view ){
    // szybkość przewijania [pixel/s]
    const speed = 100;
    // długość wyświetlanej części paska
    const getViewWidth = ()=>{
      return view.outerWidth(true);
    };
    // długość całkowita przewijanego paska
    const getFullWidth = ()=>{
      return pasek.find('.items .box:first').prop('scrollWidth');
    };

    pasek.find('.items').prepend('<div class="box"></div>');
    pasek.find('.items .item').detach().appendTo( pasek.find('.items .box') );
    pasek.find('.items .box').clone().appendTo( pasek.find('.items') );

    let mainTL = new TimelineMax({
      repeat: -1,
    })
    .add( TweenMax.fromTo(
      pasek.find('.items .box'),
      getFullWidth()/speed,
      {
        x: 0,
      },
      {
        x: getFullWidth() * (-1),
        ease: Linear.easeNone,
      }
    ) );

    view.on({
      mouseenter: (e)=>{
        mainTL.pause();
      },
      mouseleave: (e)=>{
        mainTL.resume();
      },
    });

  })(
    $('#pilne'),
    $('#pilne .items'),
    $('#pilne .items .item')
  );

});
