$(window).on('scroll', function () {
  // Header Sticky JS
  if ($(this).scrollTop() > 150) {
      $('header').addClass("is-sticky");
  }
  else {
      $('header').removeClass("is-sticky");
  };

  // Go To Top JS
  var scrolled = $(window).scrollTop();
  if (scrolled > 200) $('.go-top').addClass('active');
  if (scrolled < 200) $('.go-top').removeClass('active');
});

$('.homepage-slider-banner').slick({
    dots: false,
    // arrows: false,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    infinite: true,
    autoplaySpeed: 2000,
  });
$('.clinic-reviews-slider').slick({
    dots: true,
    infinite: false,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 1,
    infinite: true,
    // autoplaySpeed: 2000,
    centerPadding: '60px',
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
$('.slider-related').slick({
    dots: true,
    infinite: false,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 1,
    infinite: true,
    // autoplaySpeed: 2000,
    centerPadding: '60px',
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

$('.readmorehidden').click(function(){
    $('.readmorehidden').hide()
    $('.show-text-box').hide();
    $('.hidden-text-box').show();
})

$('.down-hide-show').click(function(){
  $('.Archives ul').css("height", "auto");
  $(this).hide();
})

  