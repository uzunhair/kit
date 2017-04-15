$(document).ready(function () {
    $(function () {
        $('[data-toggle="tooltip"]').tooltips()
    });

    $('.ajax-modal a').on('click', function(){
        $('body').addClass('modal-open');
    });
    $('a.ajax-modal').on('click', function(){
        $('body').addClass('modal-open');
    });
    $(".dot-1-1").dotdotdot();
});

