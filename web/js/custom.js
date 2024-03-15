$(document).ready(function(){

    // Back to top button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
          $('.back-to-top').fadeIn('slow');
        } else {
          $('.back-to-top').fadeOut('slow');
        }
    });

    $('.back-to-top').click(function() {
        $('html, body').animate({
          scrollTop: 0
        }, 1000, 'easeInOutExpo');
        return false;
    });

        
    window.onscroll = function() {myFunction()};

    var header = document.getElementsByClassName("header")[0];
    var sticky = header.offsetTop;
    

    function myFunction() {
        if (window.pageYOffset > sticky) {
            header.classList.add("fixed");

        } else {
            header.classList.remove("fixed");
        }
    }


    var lang = $('html').attr('lang');
    if(lang == 'en'){
        // Slider
        $('.slider-carousel').owlCarousel({
            rtl:false,
            loop:true,
            center:true,
            nav:true,
            dots:false,
            autoplay:true,
            slideTransition:'linear',
            margin:0,
            autoplayHoverPause: true,
            navText : ['<i class="fas fa-chevron-right"></i>','<i class="fas fa-chevron-left"></i>'],
            // dotsContainer: '.container',
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });

        // new
        $('.slider-add-carousel').owlCarousel({
            rtl:false,
            loop:true,
            center:true,
            nav:true,
            dots:false,
            autoplay:true,
            slideTransition:'linear',
            margin:0,
            autoplayHoverPause: true,
            navText : ['<i class="fas fa-chevron-right"></i>','<i class="fas fa-chevron-left"></i>'],
            // dotsContainer: '.container',
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });
    }else{
        $('.slider-carousel').owlCarousel({
            rtl:true,
            loop:true,
            center:true,
            nav:true,
            dots:false,
            autoplay:true,
            slideTransition:'linear',
            margin:0,
            autoplayHoverPause: true,
            // dotsContainer: '.container',
            navText : ['<i class="fas fa-chevron-right"></i>','<i class="fas fa-chevron-left"></i>'],
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });
        // new
        $('.slider-add-carousel').owlCarousel({
            rtl:true,
            loop:true,
            center:true,
            nav:true,
            dots:false,
            autoplay:true,
            slideTransition:'linear',
            margin:0,
            autoplayHoverPause: true,
            // dotsContainer: '.container',
            navText : ['<i class="fas fa-chevron-right"></i>','<i class="fas fa-chevron-left"></i>'],
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });
    }

    // mobile menu
    $('.menu-button').on('click', function () {
        $('.mobile-menu-overlay').addClass('active');
        $('.menu-mobile').addClass('menu-mobile-active');
    });

    $('.close-menu').on('click', function () {
        $('.mobile-menu-overlay').removeClass('active');
        $('.menu-mobile').removeClass('menu-mobile-active');
    });

    // sub menu
    $('.sub-menu-button').on('click', function () {
        $('.sub-menu-overlay').addClass('active');
        $('.sub-menu').addClass('menu-sub-active');
    });

    $('.sub-close-menu').on('click', function () {
        $('.sub-menu-overlay').removeClass('active');
        $('.sub-menu').removeClass('menu-sub-active');
    });

    $('#show-grid').on('click', function () {
        // $('#grid-view').show();
        // $('#list-view').hide();
        $('.grid-icon').addClass('active-list');
        $('.list-icon').removeClass('active-list');
        $('input[name="style_view"]').val('grid');
        filterSearch();

    });

    $('#show-list').on('click', function (e) {
        // $('#grid-view').hide();
        // $('#list-view').show();
        $('.grid-icon').removeClass('active-list');
        $('.list-icon').addClass('active-list');
        $('input[name="style_view"]').val('list');
        filterSearch();
        e.preventDefault();


    });

    $('#pills-tab [data-toggle="pill"]').on('click', function (e) {
        value = $(this).attr('value');
        $('input[name="ad_subtype"]').val(value);
        filterSearch();
        e.preventDefault();

    });



    $('#showPriceControls').on('click', function(e) {
        $('#showDisControls').removeClass('focus')
        $(this).toggleClass('focus')
        $('.disInputs').hide()
        $('.priceInputs').toggle()
    })

    $('#showDisControls').on('click', function(e) {
        $('#showPriceControls').removeClass('focus')
        $(this).toggleClass('focus')
        $('.priceInputs').hide()
        $('.disInputs').toggle()
    })
     

     
    $('#showPriceControlsMobile').on('click', function(e) {
        $('#showDisControlsMobile').removeClass('focus')
        $(this).toggleClass('focus')
        // $('.mobile-show .disInputs').hide()
        $('.mobile-show .priceInputs').toggle()
    })
    $('#showDisControlsMobile').on('click', function(e) {
        $('#showPriceControlsMobile').removeClass('focus')
        $(this).toggleClass('focus')
        // $('.mobile-show .priceInputs').hide()
        $('.mobile-show .disInputs').toggle()
    })


    // image zoom
    // $('.jqzoom').jqzoom({
    //     zoomType: 'innerzoom',
    //     preloadImages: false,
    //     alwaysOn: false,
    //     title: false
    // });
    //initiate the plugin and pass the id of the div containing gallery images
    // $('#img_01').ezPlus({
    //     zoomType: 'inner', //window is default,  also 'lens
    //     cursor: 'crosshair',
    //     // zoomType: 'lens',
    //     // lensShape: 'round',
    //     // lensSize: 200,
    //     gallery: 'gal1',
    //     // zoomWindowWidth: 400,
    //     // zoomWindowHeight: 400,
    //     // zoomWindowOffsetX: 10,
    //     // zoomWindowPosition: 1,
    //     scrollZoom: false,
    //     // cursor: "crosshair",
    //     container:'ZoomContainer',
    //     // borderColour:'#f1f2f3',
    //     // borderSize:  1,
    //     zIndex: 999,
    //     responsive : true
    //     // respond: [
            
    //     // ]


    // });

    // $('.btn-submit').on('click', function (){
    //     $(this).attr('disabled', true)
    // })
});

