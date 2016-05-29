/**
Demo script to handle the theme demo
**/

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        $('.page-header-top > .container').removeClass("container").addClass('container-fluid');
        $('.page-header-menu > .container').removeClass("container").addClass('container-fluid');
        $('.page-head > .container').removeClass("container").addClass('container-fluid');
        $('.page-content > .container').removeClass("container").addClass('container-fluid');
        $('.page-prefooter > .container').removeClass("container").addClass('container-fluid');
        $('.page-footer > .container').removeClass("container").addClass('container-fluid');

        $("body").addClass("page-header-menu-fixed");
    });
} 