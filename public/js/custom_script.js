// if (location.pathname.split("/")[3]) {
//     $('.sidebar-nav .nav .nav-item a[href^="/' + location.pathname.split("/")[1] + '/' + location.pathname.split("/")[2] + '/' + location.pathname.split("/")[3] +'"]').addClass('active');
// }
// else if (location.pathname.split("/")[2]) {
//     $('.sidebar-nav .nav .nav-item a[href^="/' + location.pathname.split("/")[1] + '/' + location.pathname.split("/")[2] + '"]').addClass('active');
// }
// else {
//     $('.sidebar-nav .nav .nav-item .dashboard-link').addClass('active');
// }


$('a[href="' + window.location.href + '"]').addClass("active");