(function ($) {
    "use strict";
    $(document).ready(function () {
        /*====================================
                Sticky Header JS
            ======================================*/
        jQuery(window).on("scroll", function () {
            if ($(this).scrollTop() > 100) {
                $(".header").addClass("sticky");
            } else {
                $(".header").removeClass("sticky");
            }
        });

        /*==============================
                Mobile Menu JS
            ================================*/
        $(".menu").slicknav({
            prependTo: ".mobile-menu",
        });

        $(".mobile-arrow").on("click", function () {
            $(".mobile-menu").toggleClass("active");
        });
        /*====================================
                Search Form JS
            ======================================*/
        $(".search-form .icon").on("click", function () {
            $(".search-form").toggleClass("active");
        });

        /*====================================
                Wow JS
            ======================================*/
        var window_width = $(window).width();
        if (window_width > 767) {
            new WOW().init();
        }

        /*====================================
                Main Slider JS
            ======================================*/
        $(".slider-area").owlCarousel({
            loop: true,
            smartSpeed: 700,
            autoplay: true,
            autoplayTimeout: 8000,
            autoplayHoverPause: true,
            singleItem: true,
            margin: 30,
            animateOut: "fadeOut",
            animateIn: "fadeIn",
            items: 1,
            dots: true,
            nav: true,
            navText: [
                '<i class="fa fa-angle-up" aria-hidden="true"></i>',
                '<i class="fa fa-angle-down" aria-hidden="true"></i>',
            ],
            responsive: {
                320: {
                    dots: false,
                    nav: false,
                },
                768: {
                    dots: true,
                    nav: true,
                },
                1170: {
                    dots: true,
                    nav: true,
                },
            },
        });

        /*====================================
                Service Slider JS
            ======================================*/
        $(".service-slider").slick({
            autoplay: true,
            speed: 800,
            autoplaySpeed: 3500,
            slidesToShow: 4,
            pauseOnHover: true,
            centerMode: true,
            centerPadding: "0px",
            dots: false,
            arrows: true,
            cssEase: "ease",
            // speed: 700,
            draggable: true,
            prevArrow:
                '<button class="Prev"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></button>',
            nextArrow:
                '<button class="Next"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>',
            responsive: [
                {
                    breakpoint: 800,
                    settings: {
                        arrows: true,
                        slidesToShow: 2,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        arrows: false,
                        slidesToShow: 1,
                    },
                },
                {
                    breakpoint: 350,
                    settings: {
                        arrows: false,
                        slidesToShow: 1,
                    },
                },
            ],
        });

        /*====================================
                Blog Slider JS
            ======================================*/
        $(".blog-slider").slick({
            autoplay: true,
            speed: 700,
            autoplaySpeed: 3500,
            slidesToShow: 3,
            pauseOnHover: true,
            dots: false,
            arrows: true,
            cssEase: "ease",
            // speed: 500,
            // arrows: true,
            draggable: true,
            prevArrow:
                '<button class="Prev"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></button>',
            nextArrow:
                '<button class="Next"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>',
            responsive: [
                {
                    breakpoint: 800,
                    settings: {
                        arrows: true,
                        slidesToShow: 2,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        arrows: false,
                        slidesToShow: 1,
                    },
                },
                {
                    breakpoint: 350,
                    settings: {
                        arrows: false,
                        slidesToShow: 1,
                    },
                },
            ],
        });

        /*======================================
                Parallax JS
            ======================================*/
        $(window).stellar({
            responsive: true,
            horizontalOffset: 0,
            verticalOffset: 0,
        });

        /*====================================
                Nice Select JS
            ======================================*/
        $("select").niceSelect();

        /*====================================
                Counter JS
            ======================================*/
        $(".count").counterUp({
            time: 1000,
        });

        /*====================================
                Scroll To Top JS
            ======================================*/
        $(".top-arrow .btn").on("click", function (event) {
            var $anchor = $(this);
            $("html, body")
                .stop()
                .animate(
                    {
                        scrollTop: $($anchor.attr("href")).offset().top - 20,
                    },
                    1000,
                    "easeInOutQuart"
                );
            event.preventDefault();
        });
    });
    /*=====================================
              Video Popup JS
          ======================================*/
    $(".video-popup").magnificPopup({
        type: "iframe",
        removalDelay: 300,
        mainClass: "mfp-fade",
    });

    /*====================================
              Preloader JS
          ======================================*/
    $(window).load(function () {
        $(".preloader").fadeOut("slow", function () {
            $(this).remove();
        });
    });
})(jQuery);
