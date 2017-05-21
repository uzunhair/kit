$(document).ready ( function(){

    $('#header_nav_class').on('change', function (){
        if($(this).val().includes('navbar-fixed-top')){
            $("#f_body_padding_top").show("500");
        } else {
            // else do
            $("#f_body_padding_top").hide("500");
        }
        if($(this).val().includes('navbar-fixed-bottom')){
            $("#f_body_padding_bottom").show("500");
        } else {
            // else do
            $("#f_body_padding_bottom").hide("500");
        }
    }).trigger('change');

});

function colorpalette(element) {
    var colorpaletteItem = $(element).find('.dropdown-item');
    var colorpaletteInput = $(element).children('.form-control');
    var colorpaletteBtn = $(element).children('.colorpaletteBtn');

    $(colorpaletteItem).each(function (index, value) {
        var color = $(this).attr('data-color');
        var text = $(this).text();
        $(this).attr('title', text).css('background-color', color);
        $(this).text('');

        // console.log('a' + index + ':' + $(this).attr('value'));
    });

    colorpaletteItem.click(function () {
        var title = $(this).attr('title');
        var thisParent = $(this).parents(element);
        thisParent.children('.colorpaletteBtn').removeClass().addClass('btn colorpaletteBtn ' + title);
        thisParent.children('.form-control').val(title);

        console.log("string", title, thisParent);
    });

    colorpaletteInput.on("change paste keyup", function () {
        var val = $(this).val();
        colorpaletteBtn.removeClass().addClass('btn colorpaletteBtn ' + val);
        console.log("string", val);
    });
};