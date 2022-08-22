// Shows loading before redirect
$('a[href^="http"][target!="_blank"]').on('click',function(){
    $('.loadingPage').fadeIn(3000);
});
$('.loadingPage').on('click',function(){ $('.loadingPage').hide(); });

// Closes navbar on mobile when clicking on link
$('.navbar-nav li a').on('click', function(){
    if(!$( this ).hasClass('dropdown-toggle')){
        $('.navbar-collapse').collapse('hide');
    }
});

// Scrolls to div when click is on anchor with notscrollable class
$('a').not('.notscrollable').click(function(){
    $('html, body').animate({
        scrollTop: $( $(this).attr('href') ).offset().top - 55
    }, 1000);
    return false;
});

// This will prevent the default action of the anchor on notscrollable class
$('.notscrollable').click(function(event) {    
    event.preventDefault();
});

// On page load, check if URL has hash and add scroll
$(document).ready(function() {
    if (window.location.hash) {
        setTimeout(function() {
            $('html, body').scrollTop(0).show();
            $('html, body').animate({
                scrollTop: $(window.location.hash).offset().top - 55
                }, 1000)
        }, 0);
    }
});