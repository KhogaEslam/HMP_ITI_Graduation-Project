if (location.pathname.split("/")[2]) {
    $('.sidebar-nav .nav .nav-item a[href^="/' + location.pathname.split("/")[1] + '/' + location.pathname.split("/")[2] + '"]').addClass('active');
}
else {
    $('.sidebar-nav .nav .nav-item .dashboard-link').addClass('active');
}