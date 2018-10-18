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

    $("#concludiA").click(function(){

        //if (confirm("Are you sure?"))

        var nome_componente = $('#nome_componenteA').val();
        var annotazioni = $('#annotazioniA').val();
        var anni = $("#anni_componenteA").val();

        if(nome_componente.trim()=='' ||
            annotazioni.trim()=='' || anni.trim() == '') {
            alert('Tutti i campi sono obbligatori.');
        } else {

            $('#concludiA').prop('disabled',true);

            var nuovo = $.post("formscripts/aggiungiAnamnesiFamiliare.php",
                {

                    nome_componente:  $("#nome_componenteA").val(),
                    grado_parentela:  $("#gradoParentela").val(),
                    sesso:            $("#sessoA").val(),
                    anni_componente:  $("#anni_componenteA").val(),
                    data_morte:       $("#data_morteA").val(),
                    annotazioni:      $("#annotazioniA").val(),
                },
                function(status) {
                    alert("Status: " + "Salvataggio avvenuto correttamente");
                    //alert(status);

                    window.location.reload();

                    //alert($("#nome_componenteA").val() + "::" + $("#sessoA").val() + "::" + $("#anni_componenteA").val() + "::" + $("#annotazioniA").val());
                });
        }

    });
});

// evento per quando viene cliccato il pulsante elimina

$(document).on('click', "button.elimina", function () {
    if (confirm("Eliminare la anamnesi selezionata?")){
        $.post("formscripts/rimuoviAnamnesiFamiliare.php",
            {
                id_anamnesi: $(this).attr('id'),
            },
            function(status){
                //alert("Status: " + status);
                window.location.reload();
            });
    }
});

// evento per quando viene cliccato il pulsante modifica

$(document).on('click', "button.modifica", function () {
    var main_id = ($(this).attr('id')).split("_")[1];

    if (confirm("Modificare l'anamnesi selezionata?")){
        $.post("formscripts/modificaAnamnesiFamiliare.php",
            {
                id_anamnesi:      main_id,
                nome_componente:  $("#nome_componenteA_" + main_id).val(),
                grado_parentela:  $("#gradoParentelaA_" + main_id).val(),
                sesso:            $("#sessoA_" + main_id).val(),
                anni_componente:  $("#anni_componenteA_" + main_id).val(),
                data_morte:       $("#data_morteA_" + main_id).val(),
                annotazioni:      $("#annotazioniA_" + main_id).val(),
            },
            function(status){
                //alert("Status: " + status);
                window.location.reload();
            });
    }
});