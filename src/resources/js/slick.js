$(document).ready(function () {
  /**
   * カルーセル設定
   */
  function initSlick() {
    const $carousel = $('#nav-carousel');

    // PCの場合のみカルーセルにする
    if ($(window).width() >= 768 && !$carousel.hasClass('slick-initialized')) {
      $carousel.slick({
        infinite: false,
        slidesToShow: 5,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<button type="button" class="slick-prev"><i class="fa-solid fa-circle-chevron-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fa-solid fa-circle-chevron-right"></i></button>',
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 4
            }
          }
        ]
      });

      // スマホは不要
    } else if ($(window).width() < 768 && $carousel.hasClass('slick-initialized')) {
      $carousel.slick('unslick');
    }
  }

  initSlick();

  $(window).on('resize', function () {
    initSlick();
  });
});