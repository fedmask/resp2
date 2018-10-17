//Magarelli-Marzulli Sspera marzo 2017

$(document).ready(function(){

    jQuery.fn.outerHTML = function() {
        return jQuery('<div />').append(this.eq(0).clone()).html();
    };


    $('#buttonUpdateFam').click(function(){
        $('#buttonUpdateFam').hide();
        $('#buttonAnnullaFam').show();
        $('#btn_salvafam').show();
        $('#buttonCodiciFam').show();

        $('#testofam').prop('readonly', false)
    });

    $('#buttonAnnullaFam').click(function(){
        if (confirm('Eliminare le modifiche correnti?') == true) {
            $('#buttonUpdateFam').show();
            $('#buttonAnnullaFam').hide();
            $('#btn_salvafam').hide();
            $('#buttonCodiciFam').hide();

            $('#testofam').prop('readonly', true)
            window.location.reload();
        }
    });


});