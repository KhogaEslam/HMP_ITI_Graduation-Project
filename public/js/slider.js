//$('.carousel').carousel()
//
//$('.carousel').carousel({
//  interval: 2000
//})

$( document ).ready(function() {
    $(".fav i").click(function(){
        $(this).toggleClass("fa-star-o");
        $(this).toggleClass("fa-star");
    });

    $('#myCarousel').carousel({
        interval:   4000
    });

    var clickEvent = false;
    $('#myCarousel').on('click', 'nav-justified a', function() {
        clickEvent = true;
        $('.nav li').removeClass('active');
        $(this).parent().addClass('active');
    }).on('slid.bs.carousel', function(e) {
        if(!clickEvent) {
            var count = $('.nav-justified').children().length -1;
            var current = $('.nav-justified li.active');
            current.removeClass('active').next().addClass('active');
            var id = parseInt(current.data('slide-to'));
            if(count == id) {
                $('.nav-justified li').first().addClass('active');
            }
        }
        clickEvent = false;
    });


});