$('.slider').each(function(){
  var slickInduvidual = $(this);
  slickInduvidual.slick({
    // centerPadding: "10px",
    infinite: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    nextArrow: slickInduvidual.next().find('.next'),
    prevArrow: slickInduvidual.next().find('.prev'),
    responsive: [
      {
        breakpoint: 840,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 560,
        settings: {
          slidesToShow: 1,
        }
      },
    ],
  });
});
