// Single pet post
// Form submit
document.addEventListener( 'wpcf7mailsent', function( event ) {
$('#ModalWhats').css('display','grid');
}, false );

// Slick slider
$('.pet-galeria').slick({
infinite: true,
slidesToShow: 1,
slidesToScroll: 1,
dots: false,
arrows: false,
autoplay: true,
autoplaySpeed: 2500,
adaptiveHeight: true,
draggable: true,
asNavFor: '.pet-nav',
responsive: [
    {
        breakpoint: 900,
        settings: {
        slidesToShow: 1,
        slidesToScroll: 1
    }
    },
    {
        breakpoint: 610,
        settings: {
        slidesToShow: 1,
        slidesToScroll: 1
    }
    }
]
});


var slideCount = jQuery(".pet-nav .single").length;
if (slideCount == 1) {

    $('.pet-nav').addClass('one');

    // Exibe apenas 1
    $('.pet-nav').slick({
    // infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    // centerMode: true,
    // asNavFor: '.pet-galeria',
    responsive: [
        {
            breakpoint: 900,
            settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
        },
        {
            breakpoint: 610,
            settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
        }
    ]
    });

}

else if (slideCount == 2) {
    
    $('.pet-nav').addClass('two');

    // Clona
    $(".pet-nav").children().clone(true, true).appendTo(".pet-nav");

    // Exibe apenas 2
    $('.pet-nav').slick({
    infinite: true,
    slidesToShow: 2,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    // centerMode: true,
    focusOnSelect: true,
    asNavFor: '.pet-galeria',
    responsive: [
        {
            breakpoint: 900,
            settings: {
            slidesToShow: 2,
            slidesToScroll: 1
        }
        },
        {
            breakpoint: 610,
            settings: {
            slidesToShow: 2,
            slidesToScroll: 1
        }
        }
    ]
    });

}

else if (slideCount == 3) {

    // clone element
    $(".pet-nav").children().clone(true, true).appendTo(".pet-nav");

    $('.pet-nav').addClass('three');

    // Exibe apenas 2
    $('.pet-nav').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    focusOnSelect: true,
    // centerMode: true,
    asNavFor: '.pet-galeria',
    responsive: [
        {
            breakpoint: 900,
            settings: {
            slidesToShow: 3,
            slidesToScroll: 1
        }
        },
        {
            breakpoint: 610,
            settings: {
            slidesToShow: 3,
            slidesToScroll: 1
        }
        }
    ]
    });
    
}

else if (slideCount > 3) {

    $('.pet-nav').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    // centerMode: true,
    focusOnSelect: true,
    asNavFor: '.pet-galeria',
    responsive: [
        {
            breakpoint: 900,
            settings: {
            slidesToShow: 3,
            slidesToScroll: 1
        }
        },
        {
            breakpoint: 610,
            settings: {
            slidesToShow: 2,
            slidesToScroll: 1
        }
        }
    ]
    });
    
}