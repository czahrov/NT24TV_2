$(function(){

  // obsługa przycisku ładowania kolejnych wpisów w kategorii
  $('body #btn_more')
  .each(function(){
    let _ = $(this);
    _.on({
      click: function(e){7
        // let items = _.prevAll('.mid_post').find('.item');
        let items = _.parent('.items').find('.item');
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
              // root.append(t);
              _.before(t);
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
  $('#UGallery').unitegallery({
    gallery_theme: "tiles",
    tiles_type: "justified",
    // gallery_width: '100%',
    // tiles_type: "nested",
    lightbox_type: 'compact',
    tile_overlay_color: '#e3000f',
    tiles_col_width: 150,
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

  // obsługa osadzanego video
  (function( videos, video_youtube, video_media ){
    let players = [];

    // pseudo interface dla odtwarzaczy
    videos.each(function(){
      let _ = $(this);
      let isPined = true;
      let fixed_video = $('#fixed_video');
      let video_start = _.offset().top;
      let video_end = video_start + _.outerHeight(true);
      let autoplay = _.find('.player').attr('data-autoplay') == 1;
      let muted = _.find('.player').attr('data-muted') == 1;
      let isPlayed = false;
      const inView = function(){
        let screen_start = $('html,body').prop('scrollTop') + $('nav.navbar').outerHeight(true);
        let screen_end = $('html,body').prop('scrollTop') + window.innerHeight;

        if( video_end >= screen_start && video_start <= screen_end ){
          // w polu widzenia
          return true;
        }
        else{
          // poza polem widzenia
          return false;
        }

      };
      let lastState = -1;
      let overlay = _.find('.overlay');
      let TL_mute = new TimelineMax({
        paused: true,
      })
      .add(
        TweenMax.fromTo(
          overlay,
          0.1,
          {
            scale: 0,
          },
          {
            scale: 1,
          }
        ),
        0
      )
      .add(
        TweenMax.fromTo(
          overlay,
          0.3,
          {
            opacity: 0,
          },
          {
            opacity: 1,
          }
        ),
        '+=0',
        'sequence'
      );

      _.on({
        mute: function(e){
          console.log('player.mute()');
          TL_mute.play();
        },
        unmute: function(e){
          console.log('player.unmute()');
          TL_mute.reverse();
        },
        play: function(e){
          console.log('player.play()');
        },
        pause: function(e){
          console.log('player.pause()');
        },
        exit: function(e){
          console.log('player.exit()');
        },
        pop: function(e){
          isPined = false;
          $( _ ).before(
            $('<div class="placeholder"></div>')
            .css({
              minHeight: function(){
                return _.outerHeight(true);
              }
            })
          );
          _.addClass('pop');
          console.log('player.pop()');
        },
        pin: function(e){
          isPined = true;
          _.prevAll('.placeholder').remove();
          _.removeClass('pop');
          console.log('player.pin()');
        },
        playerReady: function(e){
          console.log('player.onReady()');
          if ( $('#post').length ) {
            _.triggerHandler('play');
            _.triggerHandler('mute');
          }
          else{
            if( autoplay ){
              if( muted ){
                _.triggerHandler('mute');
              }
              else{
                _.triggerHandler('unmute');
              }
            }
            else{
              _.triggerHandler('unmute');
            }
          }

          // włączanie/pauzowanie filmu gdy (nie)będzie w polu widzenia
          $(window)
          .scroll(function(e){
            if( autoplay ){
              if ( inView() && !isPlayed ) {
                _.triggerHandler('play');
                if(lastState > -1) isPlayed = true;
              }
              if ( $('#post').length == 0 && !inView() && isPlayed ) {
                _.triggerHandler('pause');
                isPlayed = false;
              }
            }
          })
          .scroll();
        },
        getPlayer: function(e){
          console.log('player.getPlayer()');
        },
        getPlayerState: function(e){
          return lastState;
        },
        playerStateChange: function(e, state){
          console.log('player.playerStateChange('+state+')');
          lastState = state;
          switch ( state ) {
            case -1: // unstarted

              break;
            case 0: // ended
              _.triggerHandler('pin');
              break;
            case 1: // played

              break;
            case 2: // paused
              _.triggerHandler('pin');
              break;
            case 3: // buffering

              break;
            case 5: // video cued

              break;
            default:

          }
        },
      });

      $('body').keydown(function(e){
        // console.log('player.keydown('+e.code+')');
        switch (e.code) {
          case 'Escape':
            _.triggerHandler('pause');
            break;
          default:

        }
      });

      // wyłączenie wyciszenia
      _.find('.overlay').click((e)=>{
        _.triggerHandler('unmute');
      });

      // pływający odtwarzacz
      if( $('#post').length ){
        $(window).scroll(function(e){
          // sprawdzanie czy odtwarzacz jest w polu widzenia
          if( inView() ){
            // w polu widzenia
            if ( !isPined ) _.triggerHandler('pin');
          }
          else{
            // poza polem widzenia
            if ( isPined && [1].indexOf( lastState ) > -1 ) _.triggerHandler('pop');
          }
        });
      }

    });

    // obsługa filmów youtube
    if ( video_youtube.length ) {
      $.getScript( 'https://www.youtube.com/iframe_api' );
      window.onYouTubeIframeAPIReady = function(){
        video_youtube.each(function(){
          let _ = $(this);
          let root = _.parents("#video:first");
          let player = null;
          let videoID = _.attr('data-video');
          let autoplay = _.attr('data-autoplay');
          let muted = _.attr('data-muted');
          let controls = _.attr('data-controls');
          let player_width = _.attr('data-width');
          let player_height = _.attr('data-height');
          let overlay = root.find('.overlay');
          const isiOS = $('body').hasClass('ios');
          const isAndroid = $('body').hasClass('android');

          console.log('onYouTubeIframeAPIReady()');
          player = new YT.Player( _[0], {
            videoId: videoID,
            width: player_width,
            height: player_height,
            playerVars:{
              // autoplay: autoplay,
              autoplay: 0,
              controls: controls,
              rel: 0,
              origin: window.location.origin,
              enablejsapi: 1,
              playsinline: 1,
            },
            events:{
              onReady: function(e){
                root.triggerHandler('playerReady');
              },
              onStateChange: function(e){
                root.triggerHandler('playerStateChange',[e.data]);
              },
            }
          } );
          players.push( player );
          window.player_helper = players;

          _.on({
            onInteract: function(e){
              $('body')
              .one('touchend', function(e){
                player.playVideo();
              })
              .one('click', function(e){
                player.playVideo();
              });
            },

          });

          root.on({
            mute: function(e){
              player.mute();
              // TL_mute.play();
              console.log('player is muted');
            },
            unmute: function(e){
              player.unMute();
              // TL_mute.reverse();
              console.log('player is unmuted');
            },
            play: function(e){
              player.playVideo();

              if ( isiOS ) {
                _.triggerHandler('onInteract');
              }

              console.log('player is played');
            },
            pause: function(e){
              player.pauseVideo();
              console.log('player is paused');
            },
            getPlayer: function(e){
              return player;
            },
          });

        });

      }

    }

    // obsługa filmów z mediów
    if ( video_media.length ) {
      video_media.each(function(){
        let _ = $(this);
        let root = _.parents("#video:first");
        let player = _[0];
        let videoID = _.attr('data-video');
        let autoplay = _.attr('data-autoplay');
        let muted = _.attr('data-muted');
        let controls = _.attr('data-controls');
        let player_width = _.attr('data-width');
        let player_height = _.attr('data-height');
        let overlay = root.find('.overlay');

        root.on({
          mute: function(e){
            player.muted = true;
            console.log('player is muted');
          },
          unmute: function(e){
            player.muted = false;
            console.log('player is unmuted');
          },
          play: function(e){
            player.play();
            console.log('player is played');
          },
          pause: function(e){
            player.pause();
            console.log('player is paused');
          },
          getPlayer: function(e){
            return player;
          },
        });

        _.on({
          playing: function(e){
            console.log('media_player.plaing()');
            root.triggerHandler('playerStateChange', [1]);
          },
          pause: function(e){
            console.log('media_player.pause()');
            root.triggerHandler('playerStateChange', [2]);
          },
          ended: function(e){
            console.log('media_player.ended()');
            root.triggerHandler('playerStateChange', [0]);
          },
          loadeddata: function(e){
            console.log('media_player.loadeddata()');
            root.triggerHandler('playerReady');
          },
        });

      });

    }

  })(
    $('[id="video"]'),
    $('[id="video"] .player[data-player-type="youtube"]'),
    $('[id="video"] .player[data-player-type="media"]')
  );

  // przewijany pasek informacyjny
  (function( pasek, view ){
    // szybkość przewijania [pixel/s]
    const speed = 50;
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

  // popup
  (function(popup, box, view, controls){
    let popup_show_TL = new TimelineMax({
      paused: true,
      onStart: function(e){
        popup.show();
      },
      onReverseComplete: function(e){
        popup.hide();
      },
    })
    .add(
      TweenMax.fromTo(
        popup,
        .5,
        {
          opacity: 0,
        },
        {
          opacity: 1,
        }
      ),
      0
    )
    .add(
      TweenMax.fromTo(
        box,
        1,
        {
          opacity: 0,
          scale: 0.5,
          xPercent: -50,
          yPercent: -50,
        },
        {
          opacity: 1,
          scale: 1,
        }
      ),
      '+=0',
      'sequence'
    )
    .totalDuration(.5);

    popup.on({
      open: function(e,url){
        popup_show_TL.play();
        if( typeof url !== 'undefined' ){
          view.empty().append('<iframe src="'+url+'"></iframe>');
        }
      },
      close: function(e){
        popup_show_TL.reverse();
      },

    });

    controls.children('.exit').click((e)=>{
      popup.triggerHandler('close');
    });

  })(
    $('#popup'),
    $('#popup .box'),
    $('#popup .box .view'),
    $('#popup .box .controls')
  );

});
