$(function(){
  const DBG = 1;

  // IntersectionObserver img lazy loading
  (function( lazy_bgimg, lazy_img ){
    try {
      if ( typeof IntersectionObserver !== 'function' ) {
        throw "IntersectionObserver not supported!\nSwitch to standard loading...";
      }
      let options = {
        root: null,
        rootMargin: '0px',
        treshold: 0,
      }
      let watcher_bg = new IntersectionObserver( function(entries){
        entries.forEach(function(entry){
          if ( entry.isIntersecting && entry.intersectionRatio >= 0 ) {
            let _ = $( entry.target );
            img_url = _.attr('data-bglazy');
            if( img_url == undefined ) return;
            _.css({
              backgroundImage: 'url('+img_url+')',
            })
            .attr('data-bglazy',null);
            // console.log( _ );
          }
        });
      });
      lazy_bgimg.each( function(){
        watcher_bg.observe( $(this)[0] );
      });
      let watcher_img = new IntersectionObserver( function(entries){
        entries.forEach(function(entry){
          if ( entry.isIntersecting && entry.intersectionRatio >= 0 ) {
            let _ = $( entry.target );
            img_url = _.attr('data-imglazy');
            if( img_url == undefined ) return;
            _
            .attr({
              'src': img_url,
              'data-imglazy': null,
            });
            // console.log( _ );
          }
        });
      });
      lazy_img.each( function(){
        watcher_img.observe( $(this)[0] );
      });
    }
    catch (e) {
      console.info( 'LazyLoading off' );
      console.error( e );
      lazy_bgimg.each(function(){
        let _ = $(this);
        _.css({
          backgroundImage: 'url('+_.attr('data-bglazy')+')',
        })
        .attr({
          'data-bglazy': null,
        });
      });
      lazy_img.each(function(){
        let _ = $(this);
        _.attr({
          'src': _.attr('data-imglazy'),
          'data-imglazy': null,
        });
      });

    }
  })(
    // document.querySelectorAll('[data-bglazy]'),
    // document.querySelectorAll('[data-imglazy]')
    $('[data-bglazy]'),
    $('[data-imglazy]')
  );

  // obsługa menu
  (function(menu, view, stack, more, dots ){
    menu
    .on({
      adjust: function(e){
        // if (DBG) console.log('adjust');
        let avail_width = function(){ return view.outerWidth() };
        let view_items_width = function(){
          if ( !view.children('.item').length ) return 0;
          let last_item = view.children('.item:last');
          return last_item.position().left + last_item.outerWidth();
        };

        // przywracanie elementów ze stacku
        dots.hide();
        view.append( stack.children('.item').detach() );

        // przenoszenie elementów do stacku
        while( view_items_width() > avail_width() ){
          // if (DBG) console.log({
          //   view_items_width: view_items_width(),
          //   avail_width: avail_width(),
          // });
          let detached_item = view.children('.item:last').detach();
          stack.prepend( detached_item );
        }

        // przełączanie widoczności stacku
        if ( stack.children('.item').length ) {
          dots.show();
        }
        else{
          dots.hide();
        }

        // zmiana wyświetlania listy
        if ( stack.children('.item').length < 3 ) {
          stack.addClass('small');
        }
        else {
          stack.removeClass('small');
        }
      },
    });

    // dostosowywanie menu przy zmianach rozdzielczości
    var resize_lock = false;
    $(window).resize(function(e){
      // if (DBG) console.log({resize_lock_status: resize_lock});
      if( !resize_lock ){
        resize_lock = true;
        // if (DBG) console.log('resize_lock on!');
        window.setTimeout(function(){
          menu.triggerHandler('adjust');
          resize_lock = false;
          // if (DBG) console.log('resize_lock off!');
        },300);
      }
    })
    .resize();

    // obsługa przełączania widoczności kropek
    more.click(function(e){
      $(this).toggleClass('open');
    });

  })(
    $('#main_menu'),
    $('#main_menu .view'),
    $('#main_menu .stack'),
    $('#main_menu .more'),
    $('#main_menu .more .dots')
  );

  // obsługa przycisku ładowania kolejnych wpisów w kategorii
  $('body #btn_more')
  .each(function(){
    let _ = $(this);
    _.on({
      click: function(e){
        let _ = $(this);
        let category = _.attr('data-category');
        let items = _.parents('.items:first').find('.item');
        let root = items.first().parent();
        let from = items.length + 1;
        let to = from + 12;
        let search = window.location.search.match(/(?:\?|&)?q=([^&]+)/);
        let cmd = _.attr('data-cmd');
        let query_elements = {
          cmd: cmd,
          cat: category,
          from: from,
          to: to,
          q: search==null?(''):( search.slice(-1) ),
        };
        console.log({query_elements:query_elements});
        let query_segments = new Array();
        $.each( query_elements, function( key, value ){
          let query_segment = key+"="+value;
          query_segments.push( query_segment );
        } );
        console.log({query_segments:query_segments});

        let query_string = query_segments.join('&');
        console.log( query_string );

        $(this).addClass('loading');

        $.ajax({
          type: 'GET',
          url: '/api?' + query_string,
          success: function( data, status, xhr ) {
            if (DBG) console.log({status:status, data:data, xhr:xhr});
            if( data.length ){
              let posts = JSON.parse( data );
              if ( posts.length < 12 ){
                _.hide();
              }
              $.each( posts.splice( 0, 12 ), function( index, item ){
                if (DBG) console.log({
                  post: item,
                });
                let t = items.last().clone();
                t.find('a').attr({
                  href: item.url,
                  title: item.title,
                });
                t.find('.cover_img')
                .css( 'background-image', 'url('+item.img+')' );
                t.find('.small-post span').html( item.short_title.replace( /\\/g, '' ) );
                // root.append(t);
                _.before(t);
                // $('#btn_more').before( t );

              } );

            }

          },
          error: function( xhr, status, error ){
            if (DBG) console.error({status:status, error:error, xhr:xhr});
          },
          complete: function( xhr, status ){
            // if (DBG) console.log( [status, xhr] );
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
      slidesToShow: 2,
      dots: false,
      arrows: true,
      appendArrows: arrows,
      prevArrow: "<img class='arrow prev' src='wp-content/themes/NT24TV/images/arrow.svg'/ alt='poprzedni'>",
      nextArrow: "<img class='arrow next' src='wp-content/themes/NT24TV/images/arrow.svg' alt='następny'/>",
      swipeToSlide: true,
      responsive: [
        {
          breakpoint: 720,
          settings:{
            slidesToShow: 1,
          }
        }
      ],
    };

    if ( !slider.hasClass('slick-initialized' ) ) {
      slider.slick(settings);
    }

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
    .click(function(e){
      e.stopPropagation();
    });

    popupBtn.click(function(e){popup.triggerHandler('open')});

  })(
    $('#search-popup'),
    $('.head-menu .search-bar'),
    $('#bot-bar .button.search')
  );

  // przewijany pasek informacyjny
  (function( pasek, view ){
    // return false;
    // szybkość przewijania [pixel/s]
    const speed = 50;
    // długość wyświetlanej części paska
    const getViewWidth = function(){
      return view.outerWidth(true);
    };
    // długość całkowita przewijanego paska
    const getFullWidth = function(){
      return pasek.find('.items .box:first').prop('scrollWidth');
    };

    pasek.find('.items').prepend('<div class="box flex-shrink-0"></div>');
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
      mouseenter: function(e){
        mainTL.pause();
      },
      mouseleave: function(e){
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

    controls.children('.exit').click(function(e){
      popup.triggerHandler('close');
    });

  })(
    $('#popup'),
    $('#popup .box'),
    $('#popup .box .view'),
    $('#popup .box .controls')
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
        // let screen_start = $('html,body').prop('scrollTop') + $('nav.navbar').outerHeight(true);
        let screen_start = $('html,body').prop('scrollTop');
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
          if (DBG) console.log('player.mute()');
          TL_mute.play();
        },
        unmute: function(e){
          if (DBG) console.log('player.unmute()');
          TL_mute.reverse();
        },
        play: function(e){
          if (DBG) console.log('player.play()');
        },
        pause: function(e){
          if (DBG) console.log('player.pause()');
        },
        exit: function(e){
          if (DBG) console.log('player.exit()');
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
          if (DBG) console.log('player.pop()');
        },
        pin: function(e){
          isPined = true;
          _.prevAll('.placeholder').remove();
          _.removeClass('pop');
          if (DBG) console.log('player.pin()');
        },
        playerReady: function(e){
          if (DBG) console.log('player.onReady()');

          if ( $('#post').length ) {
            _.triggerHandler('play');
            _.triggerHandler('mute');
          }
          else{
            if( autoplay ){
              _.triggerHandler('play');

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
              if ( inView() && !isPlayed ){
                _.triggerHandler('play');
                if(lastState > -1) isPlayed = true;
              }

              if ( $('#post').length == 0 && !inView() && isPlayed ){
                _.triggerHandler('pause');
                isPlayed = false;
              }
            }
          })
          .scroll();
        },
        getPlayer: function(e){
          if (DBG) console.log('player.getPlayer()');
        },
        getPlayerState: function(e){
          return lastState;
        },
        playerStateChange: function(e, state){
          if (DBG) console.log('player.playerStateChange('+state+')');
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
        //if (DBG)  console.log('player.keydown('+e.code+')');
        switch (e.code) {
          case 'Escape':
          _.triggerHandler('pause');
          break;
          default:

        }
      });

      // wyłączenie wyciszenia
      _.find('.overlay').click(function(e){
        _.triggerHandler('unmute');
      });

      // odpinanie i przypinanie odtwarzacza
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
      else{
        $(window).scroll(function(e){
          video_start = _.offset().top;
          video_end = video_start + _.outerHeight(true);
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

          if (DBG) console.log('onYouTubeIframeAPIReady()');
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
              if (DBG) console.log('player is muted');
            },
            unmute: function(e){
              player.unMute();
              // TL_mute.reverse();
              if (DBG) console.log('player is unmuted');
            },
            play: function(e){
              player.playVideo();

              if ( isiOS ) {
                _.triggerHandler('onInteract');
              }

              if (DBG) console.log('player is played');
            },
            pause: function(e){
              player.pauseVideo();
              if (DBG) console.log('player is paused');
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
            if (DBG) console.log('player is muted');
          },
          unmute: function(e){
            player.muted = false;
            if (DBG) console.log('player is unmuted');
          },
          play: function(e){
            player.play();
            if (DBG) console.log('player is played');
          },
          pause: function(e){
            player.pause();
            if (DBG) console.log('player is paused');
          },
          getPlayer: function(e){
            return player;
          },
        });

        _.on({
          playing: function(e){
            if (DBG) console.log('media_player.plaing()');
            root.triggerHandler('playerStateChange', [1]);
          },
          pause: function(e){
            if (DBG) console.log('media_player.pause()');
            root.triggerHandler('playerStateChange', [2]);
          },
          ended: function(e){
            if (DBG) console.log('media_player.ended()');
            root.triggerHandler('playerStateChange', [0]);
          },
          loadeddata: function(e){
            if (DBG) console.log('media_player.loadeddata()');
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

});
