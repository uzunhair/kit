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