$(document).ready(function () {
    $(function () {
        // Запускаем инициализацию tooltip
        $('[data-toggle="tooltip"]').tooltips()
    });

    $('.ajax-modal a').on('click', function () {
        // добавляем класс .modal-open к тегу body при открытии модального окна
        $('body').addClass('modal-open');
    });
    $('a.ajax-modal').on('click', function () {
        // добавляем класс .modal-open к тегу body при открытии модального окна
        $('body').addClass('modal-open');
    });

    // инициализируем плагин dotdotdot
    $(".dot-1-1").dotdotdot();
});

//Комбинация клавиш Ctrl + S
var isCtrl = false;    // для включения Ctrl
$(document).keyup(function (e) {
    if (e.which == 17) isCtrl = false;
}).keydown(function (e) {    //зажата CTRL
    if (e.which == 17) isCtrl = true;
    if (e.which == 83 && isCtrl == true) {
        e.preventDefault();
        $(".button-submit").click();
    }
});