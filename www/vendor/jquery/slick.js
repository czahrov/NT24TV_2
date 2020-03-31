$('.slider').each(function(){
  var slickInduvidual = $(this);
  slickInduvidual.slick({
  slidesToShow: 3,
  responsive: [
      {
        breakpoint: 500,
        settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        }
      }
    ],
  centerPadding: "10px",
  infinite: false,
  nextArrow: slickInduvidual.next().find('.next'),
  prevArrow: slickInduvidual.next().find('.prev')
  });
});
