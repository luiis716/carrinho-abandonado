jQuery(document).ready(function($) {
    $('.cdp-carousel').each(function() {
        var $carousel = $(this);
        var autoplay = $carousel.data('autoplay');
        var autoplaySpeed = $carousel.data('autoplay-speed') || 3000;
        var cardsPerRowDesktop = $carousel.data('cards-per-row-desktop') || 4;
        var cardsPerRowTablet = $carousel.data('cards-per-row-tablet') || 3;
        var cardsPerRowMobile = $carousel.data('cards-per-row-mobile') || 1;

        $carousel.slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: cardsPerRowDesktop,
            slidesToScroll: 1,
            autoplay: autoplay,
            autoplaySpeed: autoplaySpeed,
            prevArrow: '<button type="button" class="slick-prev">&lt;</button>',
            nextArrow: '<button type="button" class="slick-next">&gt;</button>',
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: cardsPerRowDesktop,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: cardsPerRowTablet,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: cardsPerRowMobile,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });
});
