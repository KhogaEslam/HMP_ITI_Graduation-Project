$(document).ready(function () {
    $('#myCarousel').carousel({
        interval: 4000
    });
    var clickEvent = false;
    $('#myCarousel').on('click', 'nav-justified a', function () {
        clickEvent = true;
        $('.nav li').removeClass('active');
        $(this).parent().addClass('active');
    }).on('slid.bs.carousel', function (e) {
        if (!clickEvent) {
            var count = $('.nav-justified').children().length - 1;
            var current = $('.nav-justified li.active');
            current.removeClass('active').next().addClass('active');
            var id = parseInt(current.data('slide-to'));
            if (count == id) {
                $('.nav-justified li').first().addClass('active');
            }
        }
        clickEvent = false;
    });
    //    side menu
    $(function () {
        $('.navbar-toggle').click(function () {
            $('.navbar-nav').toggleClass('slide-in');
            $('.side-body').toggleClass('body-slide-in');
            $('#search').removeClass('in').addClass('collapse').slideUp(200);
            /// uncomment code for absolute positioning tweek see top comment in css
            //$('.absolute-wrapper').toggleClass('slide-in');
        });
        // Remove menu for searching
        $('#search-trigger').click(function () {
            $('.navbar-nav').removeClass('slide-in');
            $('.side-body').removeClass('body-slide-in');
            /// uncomment code for absolute positioning tweek see top comment in css
            //$('.absolute-wrapper').removeClass('slide-in');
        });
    });
    //    single product
    $(".proImg").click(function () {
        var myImg = $(this).html();
        console.log(myImg);
        $(".originalImg").html(myImg);
    });
});