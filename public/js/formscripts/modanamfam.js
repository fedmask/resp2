/*
    Codifica ICD Spera-Magarelli
    Modifiche aggiunte: Aggiunto il bottone codici relativo alle varie anamnesi.
*/
$(document).ready(function(){


    settaOption("#fumoQuantita","#fumoAnnoInizio","#fumoAnnoFine","","#fumo");
    settaOption("#alcoolQuantita","#alcoolAnnoInizio","#alcoolAnnoFine","#alcoolTipo","#alcool");
    settaOption("#drogaQuantita","#drogaAnnoInizio","#drogaAnnoFine","#drogaTipo","#droghe");

    //TABELLA ANAMNESI FAMILIARE
    $('#btn_annullafam').click(function(){
        if (confirm('Eliminare le modifiche correnti?') == true)
        {

            $('#testofam').prop('readonly',true)
            $('#testofam').prop('value'," ")
            $('#testofam').prop('value', testo)
            $('#buttonHiddenfam').show()
            $('#btn_annullafam').hide()
            $('#btn_codicifam').hide()

        }
    });

    $('#buttonHiddenfam').click(function(){
        testo = $("#testofam").val()
        $('#btnmodfam').show()
        $('#btnmodfam').prop('style',"cursor:pointer")
        //  $('#buttonHiddenfam').hide();
        $('#btn_salvafam').show();
        $('#btn_annullafam').show();
        $('#btn_codicifam').show();
        $('#testofam').prop('readonly',false)
    });

    $('#btn_salvafam').click(function(){
        $('#buttonHiddenfam').show()
        // $('#btn_salvafam').hide()
        $('#btn_annullafam').hide()
        $('#btn_codicifam').hide()
        $('#testofam').prop('readonly',true)

        $.post("formscripts/testofam.php",
            {

                testofam:	$("#testofam").val(),

            },
            function(status){

                alert("Status: " + "Salvataggio avvenuto correttamente");
                window.location.reload();
            });
    });











    //TABELLA PATOLOGICA REMOTA
    $('#buttonHiddenPatRem').click(function(){
        testopat = $("#testopat").val()
        $('#btnmodrem').show()
        $('#btnmodrem').prop('style',"cursor:pointer")
        $('#buttonHiddenPatRem').hide()
        $('#btn_salvapatrem').show()
        $('#btn_annullapatrem').show()
        $('#btn_codicipatrem').show()
        $('#testopat').prop('readonly',false)
    });

    $('#btn_annullapatrem').click(function(){
        if (confirm('Eliminare le modifiche correnti?') == true)
        {

            $('#btnmodrem').hide()
            $('#testopat').prop('readonly',true)
            $('#testopat').prop('value'," ")
            $('#testopat').prop('value', testopat)
            $('#buttonHiddenPatRem').show()
            $('#btn_annullapatrem').hide()
            $('#btn_salvapatrem').hide()
            $('#btn_codicipatrem').hide()
        }
    });

    $('#btn_salvapatrem').click(function(){
        $('#btnmodrem').hide()
        $('#buttonHiddenPatRem').show()
        $('#btn_salvapatrem').hide()
        $('#btn_annullapatrem').hide()
        $('#testopat').prop('readonly',true)
        $('#btn_codicipatrem').hide()
        $.post("formscripts/testopat.php",
            {

                testopat:	$("#testopat").val(),
                testopatpp:	$("#testopatpp").val(),

            },
            function(status){

                alert("Status: " + "Salvataggio avvenuto correttamente");
                window.location.reload();
            });
    });





    //TABELLA PATOLOGICA PROSSIMA
    $('#buttonHiddenpp').click(function(){
        testopatpp = $("#testopatpp").val()

        $('#modbtnpp').show()
        $('#modbtnpp').prop('style',"cursor:pointer")
        $('#buttonHiddenpp').hide()
        $('#btn_salvapp').show()
        $('#btn_annullapp').show()
        $('#btn_codicipatpross').show()
        $('#testopatpp').prop('readonly',false)
    });

    $('#btn_annullapp').click(function(){
        if (confirm('Eliminare le modifiche correnti?') == true)
        {
            $('#modbtnpp').hide()
            $('#testopatpp').prop('readonly',true)
            $('#testopatpp').prop('value'," ")
            $('#testopatpp').prop('value', testopatpp)
            $('#buttonHiddenpp').show()
            $('#btn_annullapp').hide()
            $('#btn_salvapp').hide()
            $('#btn_codicipatpross').hide()
        }
    });

    $('#btn_salvapp').click(function(){
        $('#modbtnpp').hide()
        $('#buttonHiddenpp').show()
        $('#btn_salvapp').hide()
        $('#btn_annullapp').hide()
        $('#btn_codicipatpross').hide()
        $('#testopatpp').prop('readonly',true)

        $.post("formscripts/testopat.php",
            {

                testopatpp:	$("#testopatpp").val(),
                testopat:	$("#testopat").val(),

            },
            function(status){

                alert("Status: " + "Salvataggio avvenuto correttamente");
                window.location.reload();
            });
    });

    //TABELLA ANAMNESI FISIOLOGICA
    //INFANZIA
    $('#inf').click(function(){

        parto = $("#parto").val()
        tipoparto = $("#tipoparto").val()
        allattamento = $("#allattamento").val()
        sviluppoVegRel = $("#sviluppoVegRel").val()
        noteinfanzia = $("#noteinfanzia").val()

        if($('#inf').val()!='aperto'){
            $('#inf').val('aperto');
            $('#inf').prop('style', 'color:#FF7F50;');
            $('#inf2').prop('class', 'hidden');
            $('#inf3').prop('class', 'hidden');
            $('#inf4').prop('class', 'hidden');
            $('#inf5').prop('class', 'hidden');
            $('#inf6').prop('class', 'hidden');
            $('#inf7').prop('class', 'hidden');

        }else{
            $('#inf').val('chiuso');
            $('#inf').prop('style', 'color:#551A8B;');
            $('#inf2').prop('class', 'accordion-toggle');
            $('#inf3').prop('class', 'accordion-toggle');
            $('#inf4').prop('class', 'accordion-toggle');
            $('#inf5').prop('class', 'accordion-toggle');
            $('#inf6').prop('class', 'accordion-toggle');
            $('#inf7').prop('class', 'accordion-toggle');
        }


    });

    $('#btn_salvainf').click(function(){
        $('#btnannullainfanzia').prop('style',"visibility:hidden")
    });

    $('#prova').click(function(){
        $.post("formscripts/testofis.php",
            {

                noteinfanzia: $("#noteinfanzia").val(),
                parto: $("#parto").val(),
                tipoparto: $("#tipoparto").val(),
                allattamento: $("#allattamento").val(),
                sviluppoVegRel: $("#sviluppoVegRel").val(),


            },
            function(status){

                alert("Status: " + "Salvataggio avvenuto correttamente");
                window.location.reload();
            });
    });

    $('#btnannullainfanzia').click(function(){
        if (confirm('Sei sicuro di annullare? Tutte le modifiche non salvate andranno perse.') == true)
        {
            $('#parto').prop('value', parto)
            $('#tipoparto').prop('value', tipoparto)
            $('#allattamento').prop('value', allattamento)
            $('#sviluppoVegRel').prop('value', sviluppoVegRel)
            $('#noteinfanzia').prop('value', noteinfanzia)
        }
    });


    //SCOLARITA
    $('#inf2').click(function(){
        livelloScol = $("#livelloScol").val()
        if($('#inf2').val()!='aperto'){
            $('#inf2').val('aperto');
            $('#inf2').prop('style', 'color:#FF7F50;');
            $('#inf').prop('class', 'hidden');
            $('#inf3').prop('class', 'hidden');
            $('#inf4').prop('class', 'hidden');
            $('#inf5').prop('class', 'hidden');
            $('#inf6').prop('class', 'hidden');
            $('#inf7').prop('class', 'hidden');
        }else{
            $('#inf2').val('chiuso');
            $('#inf2').prop('style', 'color:#551A8B;');
            $('#inf').prop('class', 'accordion-toggle');
            $('#inf3').prop('class', 'accordion-toggle');
            $('#inf4').prop('class', 'accordion-toggle');
            $('#inf5').prop('class', 'accordion-toggle');
            $('#inf6').prop('class', 'accordion-toggle');
            $('#inf7').prop('class', 'accordion-toggle');
        }
    });

    $('#btnannullascolarita').click(function(){
        if (confirm('Sei sicuro di annullare? Tutte le modifiche non salvate andranno perse.') == true)
        {
            $('#livelloScol').prop('value', livelloScol)
        }
    });


    $('#btnsalvascolarita').click(function(){
        $.post("formscripts/testofis.php",
            {

                livelloScol:	$("#livelloScol").val(),

            },
            function(status){

                alert("Status: " + "Salvataggio avvenuto correttamente");
                window.location.reload();
            });
    });


    //STILE DI VITA
    $('#inf3').click(function(){
        attivitaFisica = $("#attivitaFisica").val()
        abitudAlim = $("#abitudAlim").val()
        ritmoSV = $("#ritmoSV").val()
        stress = $("#stress").val()
        fumo = $("#fumo").val()
        fumoAnnoInizio = $("#fumoAnnoInizio").val()
        fumoAnnoFine = $("#fumoAnnoFine").val()
        fumoQuantita = $("#fumoQuantita").val()
        alcool = $("#alcool").val()
        alcoolAnnoInizio = $("#alcoolAnnoInizio").val()
        alcoolAnnoFine = $("#alcoolAnnoFine").val()
        alcoolQuantita = $("#alcoolQuantita").val()
        alcoolTipo = $("#alcoolTipo").val()
        droghe = $("#droghe").val()
        drogaAnnoInizio = $("#drogaAnnoInizio").val()
        drogaAnnoFine = $("#drogaAnnoFine").val()
        drogaQuantita = $("#drogaQuantita").val()
        drogaTipo = $("#drogaTipo").val()
        caffeina = $("#caffeina").val()
        caffeinaQuantita = $("#caffeinaQuantita").val()
        noteStileVita = $("#noteStileVita").val()
        if($('#inf3').val()!='aperto'){
            $('#inf3').val('aperto');
            $('#inf3').prop('style', 'color:#FF7F50;');
            $('#inf2').prop('class', 'hidden');
            $('#inf').prop('class', 'hidden');
            $('#inf4').prop('class', 'hidden');
            $('#inf5').prop('class', 'hidden');
            $('#inf6').prop('class', 'hidden');
            $('#inf7').prop('class', 'hidden');
        }else{
            $('#inf3').val('chiuso');
            $('#inf3').prop('style', 'color:#551A8B;');
            $('#inf2').prop('class', 'accordion-toggle');
            $('#inf').prop('class', 'accordion-toggle');
            $('#inf4').prop('class', 'accordion-toggle');
            $('#inf5').prop('class', 'accordion-toggle');
            $('#inf6').prop('class', 'accordion-toggle');
            $('#inf7').prop('class', 'accordion-toggle');
        }
    });


    $('#btnannullavita').click(function(){
        if (confirm('Sei sicuro di annullare? Tutte le modifiche non salvate andranno perse.') == true)
        {
            $('#attivitaFisica').prop('value', attivitaFisica)
            $('#abitudAlim').prop('value', abitudAlim)
            $('#ritmoSV').prop('value', ritmoSV)
            $('#stress').prop('value', stress)
            $('#fumo').prop('value', fumo)
            $('#fumoAnnoInizio').prop('value', fumoAnnoInizio)
            $('#fumoAnnoFine').prop('value', fumoAnnoFine)
            $('#fumoQuantita').prop('value', fumoQuantita)
            $('#alcool').prop('value', alcool)
            $('#alcoolAnnoInizio').prop('value', alcoolAnnoInizio)
            $('#alcoolAnnoFine').prop('value', alcoolAnnoFine)
            $('#alcoolQuantita').prop('value', alcoolQuantita)
            $('#alcoolTipo').prop('value', alcoolTipo)
            $('#droghe').prop('value', droghe)
            $('#drogaAnnoInizio').prop('value', drogaAnnoInizio)
            $('#drogaAnnoFine').prop('value', drogaAnnoFine)
            $('#drogaQuantita').prop('value', drogaQuantita)
            $('#drogaTipo').prop('value', drogaTipo)
            $('#caffeina').prop('value', caffeina)
            $('#caffeinaQuantita').prop('value', caffeinaQuantita)
            $('#noteStileVita').prop('value', noteStileVita)
        }
    });
    $('#btnsalvavita').click(function(){
        $.post("formscripts/testofis.php",
            {


                attivitaFisica:	$("#attivitaFisica").val(),
                abitudAlim: $("#abitudAlim").val(),
                ritmoSV: $("#ritmoSV").val(),
                stress: $("#stress").val(),
                fumo: $("#fumo").val(),
                fumoAnnoInizio: $("#fumoAnnoInizio").val(),
                fumoAnnoFine: $("#fumoAnnoFine").val(),
                fumoQuantita: $("#fumoQuantita").val(),
                alcool: $("#alcool").val(),
                alcoolAnnoInizio: $("#alcoolAnnoInizio").val(),
                alcoolAnnoFine: $("#alcoolAnnoFine").val(),
                alcoolQuantita: $("#alcoolQuantita").val(),
                alcoolTipo: $("#alcoolTipo").val(),
                droghe: $("#droghe").val(),
                drogaAnnoInizio: $("#drogaAnnoInizio").val(),
                drogaAnnoFine: $("#drogaAnnoFine").val(),
                drogaQuantita: $("#drogaQuantita").val(),
                drogaTipo: $("#drogaTipo").val(),
                caffeina: $("#caffeina").val(),
                caffeinaQuantita: $("#caffeinaQuantita").val(),
                noteStileVita: $("#noteStileVita").val(),


            },
            function(status){

                alert("Status: " + "Salvataggio avvenuto correttamente");
                window.location.reload();
            });
    });


    //ATTIVITA' LAVORATIVA
    $('#inf6').click(function(){
        professione = $("#professione").val()
        noteAttLav = $("#noteAttLav").val()
        if($('#inf6').val()!='aperto'){
            $('#inf6').val('aperto');
            $('#inf6').prop('style', 'color:#FF7F50;');
            $('#inf2').prop('class', 'hidden');
            $('#inf3').prop('class', 'hidden');
            $('#inf4').prop('class', 'hidden');
            $('#inf5').prop('class', 'hidden');
            $('#inf').prop('class', 'hidden');
            $('#inf7').prop('class', 'hidden');
        }else{
            $('#inf6').val('chiuso');
            $('#inf6').prop('style', 'color:#551A8B;');
            $('#inf2').prop('class', 'accordion-toggle');
            $('#inf3').prop('class', 'accordion-toggle');
            $('#inf4').prop('class', 'accordion-toggle');
            $('#inf5').prop('class', 'accordion-toggle');
            $('#inf').prop('class', 'accordion-toggle');
            $('#inf7').prop('class', 'accordion-toggle');
        }
    });

    $('#btnannullalavoro').click(function(){
        if (confirm('Sei sicuro di annullare? Tutte le modifiche non salvate andranno perse.') == true)
        {
            $('#professione').prop('value', professione)
            $('#noteAttLav').prop('value', noteAttLav)
        }
    });
    $('#btnsalvalavoro').click(function(){
        $.post("formscripts/testofis.php",
            {
                professione:	$("#professione").val(),
                noteAttLav: $("#noteAttLav").val(),

            },
            function(status){

                alert("Status: " + "Salvataggio avvenuto correttamente");
                window.location.reload();
            });
    });

    //ALVO E MINZIONE
    $('#inf7').click(function(){
        alvo = $("#alvo").val()
        minzione = $("#minzione").val()
        noteAlvoMinz = $("#noteAlvoMinz").val()
        if($('#inf7').val()!='aperto'){
            $('#inf7').val('aperto');
            $('#inf7').prop('style', 'color:#FF7F50;');
            $('#inf2').prop('class', 'hidden');
            $('#inf3').prop('class', 'hidden');
            $('#inf4').prop('class', 'hidden');
            $('#inf5').prop('class', 'hidden');
            $('#inf6').prop('class', 'hidden');
            $('#inf').prop('class', 'hidden');
        }else{
            $('#inf7').val('chiuso');
            $('#inf7').prop('style', 'color:#551A8B;');
            $('#inf2').prop('class', 'accordion-toggle');
            $('#inf3').prop('class', 'accordion-toggle');
            $('#inf4').prop('class', 'accordion-toggle');
            $('#inf5').prop('class', 'accordion-toggle');
            $('#inf6').prop('class', 'accordion-toggle');
            $('#inf').prop('class', 'accordion-toggle');
        }
    });

    $('#btnannullaminzione').click(function(){
        if (confirm('Sei sicuro di annullare? Tutte le modifiche non salvate andranno perse.') == true)
        {
            $('#alvo').prop('value', alvo)
            $('#minzione').prop('value', minzione)
            $('#noteAlvoMinz').prop('value', noteAlvoMinz)
        }
    });
    $('#btnsalvaminzione').click(function(){
        $.post("formscripts/testofis.php",
            {
                alvo: $("#alvo").val(),
                minzione: $("#minzione").val(),
                noteAlvoMinz: $("#noteAlvoMinz").val(),

            },
            function(status){

                alert("Status: " + "Salvataggio avvenuto correttamente");
                window.location.reload();
            });
    });

    //CICLO MESTRUALE
    $('#inf5').click(function(){
        etaMenarca = $("#etaMenarca").val()
        ciclo = $("#ciclo").val()
        etaMenopausa = $("#etaMenopausa").val()
        menopausa = $("#menopausa").val()
        noteCicloMes = $("#noteCicloMes").val()
        if($('#inf5').val()!='aperto'){
            $('#inf5').val('aperto');
            $('#inf5').prop('style', 'color:#FF7F50;');
            $('#inf2').prop('class', 'hidden');
            $('#inf3').prop('class', 'hidden');
            $('#inf4').prop('class', 'hidden');
            $('#inf').prop('class', 'hidden');
            $('#inf6').prop('class', 'hidden');
            $('#inf7').prop('class', 'hidden');
        }else{
            $('#inf5').val('chiuso');
            $('#inf5').prop('style', 'color:#551A8B;');
            $('#inf2').prop('class', 'accordion-toggle');
            $('#inf3').prop('class', 'accordion-toggle');
            $('#inf4').prop('class', 'accordion-toggle');
            $('#inf').prop('class', 'accordion-toggle');
            $('#inf6').prop('class', 'accordion-toggle');
            $('#inf7').prop('class', 'accordion-toggle');
        }

    });

    $('#btnannullaciclo').click(function(){
        if (confirm('Sei sicuro di annullare? Tutte le modifiche non salvate andranno perse.') == true)
        {
            $('#etaMenarca').prop('value', etaMenarca)
            $('#ciclo').prop('value', ciclo)
            $('#etaMenopausa').prop('value', etaMenopausa)
            $('#menopausa').prop('value', menopausa)
            $('#noteCicloMes').prop('value', noteCicloMes)
        }
    });
    $('#btnsalvaciclo').click(function(){
        $.post("formscripts/testofis.php",
            {
                etaMenarca: $("#etaMenarca").val(),
                ciclo: $("#ciclo").val(),
                etaMenopausa: $("#etaMenopausa").val(),
                menopausa: $("#menopausa").val(),
                noteCicloMes: $("#noteCicloMes").val(),

            },
            function(status){

                alert("Status: " + "Salvataggio avvenuto correttamente");
                window.location.reload();
            });
    });

    //GRAVIDANZE
    $('#inf4').click(function(){
        //$('#nuovegrav').collapse('hide');
        if($('#inf4').val()!='aperto'){
            $('#inf4').val('aperto');
            $('#inf4').prop('style', 'color:#FF7F50;');
            $('#inf2').prop('class', 'hidden');
            $('#inf3').prop('class', 'hidden');
            $('#inf').prop('class', 'hidden');
            $('#inf5').prop('class', 'hidden');
            $('#inf6').prop('class', 'hidden');
            $('#inf7').prop('class', 'hidden');
        }else{
            $('#inf4').val('chiuso');
            $('#inf4').prop('style', 'color:#551A8B;');
            $('#inf2').prop('class', 'accordion-toggle');
            $('#inf3').prop('class', 'accordion-toggle');
            $('#inf').prop('class', 'accordion-toggle');
            $('#inf5').prop('class', 'accordion-toggle');
            $('#inf6').prop('class', 'accordion-toggle');
            $('#inf7').prop('class', 'accordion-toggle');
        }

    });

    $('#btnannullagrav').click(function(){
        if (confirm('Sei sicuro di annullare? Tutte le modifiche non salvate andranno perse.') == true)
        {

            $('#nuovegrav').collapse('hide');
            $('#esito').prop('value', '')
            $('#etaGravidanza').prop('value', '')
            $('#dataInizioGrav').prop('value', '')
            $('#dataFineGrav').prop('value', '')
            $('#sessoBambino').prop('value', '')
            $('#noteGravidanza').prop('value', '')
        }
    });

    $('#btnsalvagrav').click(function(){
        $.post("formscripts/testofis.php",
            {

                esito: $("#esito").val(),
                etaGravidanza: $("#etaGravidanza").val(),
                dataInizioGrav: $("#dataInizioGrav").val(),
                dataFineGrav: $("#dataFineGrav").val(),
                sessoBambino: $("#sessoBambino").val(),
                noteGravidanza: $("#noteGravidanza").val(),

            },
            function(status){

                alert("Status: " + "Salvataggio avvenuto correttamente");
                window.location.reload();
            });
    });

    $('#btnannullagrav2').click(function(){
        if (confirm('Sei sicuro di annullare? Tutte le modifiche non salvate andranno perse.') == true)
        {

            $('#insgrav').prop('class', 'accordion-toggle;');
            $('#nuovegrav').collapse('hide');
            $('#esito').prop('value', '')
            $('#etaGravidanza').prop('value', '')
            $('#dataInizioGrav').prop('value', '')
            $('#dataFineGrav').prop('value', '')
            $('#sessoBambino').prop('value', '')
            $('#noteGravidanza').prop('value', '')
        }
    });
    $('#btnsalvagrav2').click(function(){
        $.post("formscripts/testofis.php",
            {
                hiddenid: $("#hiddenid").val(),
                esit: $("#esito").val(),
                etaGravidanz: $("#etaGravidanza").val(),
                dataInizioGra: $("#dataInizioGrav").val(),
                dataFineGra: $("#dataFineGrav").val(),
                sessoBambin: $("#sessoBambino").val(),
                noteGravidanz: $("#noteGravidanza").val(),

            },
            function(status){

                alert("Status: " + "Modifica avvenuta correttamente");
                window.location.reload();
            });
    });


});



/*
* Codifica ICD Spera-Magarelli.
* Funzione che setta le label della modale in base al pulsante che la richiama.
* Chiama la funzione jsonAnamnesi.
*/
function codiciAnam(recupero_id, id_anam, grado_parentela, nome_componente){
    document.getElementById("labelICD").innerHTML = "Elenco delle patologie/sintomi codificate";
    var imgLoader="<img src='assets/img/ajax-loader.gif'>";
    document.getElementById("lblJsonAnam").innerHTML = "Attendere... "+imgLoader+" Caricamento dati!";
    $('#labelICD').prop('value', recupero_id);
    switch (recupero_id) {
        case "btn_codicifam":
            document.getElementById("titolo").innerHTML = "Codifica ICD9 - Anamnesi familiare";
            break;
        case "btn_codicipatrem":
            document.getElementById("titolo").innerHTML = "Codifica ICD9 - Anamnesi patologica remota";
            break;
        case "btn_codicipatpross":
            document.getElementById("titolo").innerHTML = "Codifica ICD9 - Anamnesi patologica prossima";
            break;
    }
    $("#btnElimina").attr("onclick","eliminaCheckAnam('"+id_anam+"')");


    jsonAnamnesi(recupero_id, id_anam, grado_parentela, nome_componente);
}

/*
* Codifica ICD Spera-Magarelli.
* Funzione che richiama lo script ../anamnesifam_patologiePaziente.php per la prima parte
* della modale che visualizza i codici ICD9 relativi all'anamnesi effettiva del paziente.
*/
function jsonAnamnesi(id, id_anam, grado_parentela, nome_componente){
    document.getElementById("btnInserisci").innerHTML = "Inserisci";
    $('#btnInserisci').prop('class', 'btn btn-info');
    if(id == "btn_codicifam"){
        $("#btnInserisci").attr("onclick","jsonCodeICD('" + id_anam + "')");
        $('#labelICD').append(" per " + grado_parentela + " " + nome_componente);
    }else
        $("#btnInserisci").attr("onclick","jsonCodeICD(\'\')");
    $('#btnInserisci').prop("disabled",false);
    document.getElementById("btnElimina").style.display = "inline-block";
    contatoreChiamate2=0;


    var url2 =  "sections/anamnesifam_patologiePaziente.php";
    url2 =  url2 + "?codiceICD=" + id + "&idAnam=" + id_anam;

    $.get(url2, function( data ) {
            document.getElementById("lblJsonAnam").innerHTML = "";
            for(var i=0;i<data.length;i++){
                var element2 = data[i];
                document.getElementById("lblJsonAnam").innerHTML += '<div><input id="checkSposta'+element2.codice+'" type="checkbox" name="id" class="checkAnamesi" value="'+ element2.codice + '"/>    ' + element2.descrizione + '</div>';
            }
        }
    );
}


/*
* Codifica ICD Spera-Magarelli.
* Funzione che richiama lo script ../anamnesifam_codificaICD.php per la
* visualizzazione dei codici ICD9 (gruppi, blocchi, categorie e codici) durante
* la fase di inserimento di una nuova patologia nell'anmnesi del paziente.
*/
function jsonCodeICD(id_anam){
    document.getElementById("btnElimina").style.display = "none";

    var url2 =  "sections/anamnesifam_codificaICD.php";

    var checkedvar2 = document.querySelector('.radioIcdAnam:checked');

    if(checkedvar2 && flag2!=0) {
        url2 =  url2 + "?codiceICD=" + checkedvar2.value;
        if((checkedvar2.value).length==1){
            contatoreChiamate2=0;
        }
        contatoreChiamate2++;
    }

    $.get(url2, function( data ) {
            document.getElementById("lblJsonAnam").innerHTML = "";
            for(var i=0;i<data.length;i++){
                var element2 = data[i];
                document.getElementById("lblJsonAnam").innerHTML += '<div><input id="codeICD" type="radio" onclick="jsonCodeICD(\'\')" name="icd" class="radioIcdAnam" value="'+ element2.codice + '"/>    ' + element2.descrizione + '</div>';
            }
            if(contatoreChiamate2==0){
                document.getElementById("labelICD").innerHTML = "Seleziona un gruppo ICD9 1/4";
                $('#btnInserisci').prop("disabled",true);
                $('#btnInserisci').prop('class', 'btn btn-success');
                $("#btnInserisci").attr("onclick","salvaRadioAnam('"+id_anam+"')");
                document.getElementById("btnInserisci").innerHTML = "Salva";
            } else if(contatoreChiamate2==1){
                document.getElementById("labelICD").innerHTML = "Seleziona un blocco ICD9 2/4";
            } else if(contatoreChiamate2==2){
                document.getElementById("labelICD").innerHTML = "Seleziona una categoria ICD9 3/4";
            } else if(contatoreChiamate2>=3){
                document.getElementById("labelICD").innerHTML = "Seleziona una diagnosi o sintomo ICD9 4/4";
                $('#btnInserisci').prop("disabled",false);
                $(".radioIcdAnam").attr("onclick","");
            }
            flag2 = 1;
        }
    );
}


/*
* Codifica ICD Spera-Magarelli.
* Funzione che permette il salvataggio di una patologia codificata appartenente
* all'anamnesi familiare, patologica remota e prossima tramite la selezione della
* rafio radioIcdAnam
*/
function salvaRadioAnam(id_anam){
    var checkSelezionata = null;
    var somma = [];
    var anamnesi = document.getElementById('labelICD');
    var inputElements = document.getElementsByClassName('radioIcdAnam');
    for(var i=0; inputElements[i]; ++i){
        if(inputElements[i].checked){
            checkSelezionata = inputElements[i].value;
        }
    }
    $.post("formscripts/testoIcd.php",
        {
            anamnesi: anamnesi.value,
            radioSalvaAnm:  checkSelezionata,
            id_anamFam: id_anam
        },
        function(status){
            alert("Status: " + "Modifica effettuata");
            window.location.reload();
        }
    );

}


/*
* Codifica ICD Spera-Magarelli.
* Funzione che permette l'eliminazione di una o più patologie codificate appartenenti
* all'anamnesi familiare, patologica remota e prossima tramite la selezione delle
* checkbox checkAnamnesi
*/
function eliminaCheckAnam(id_anam){
    var checkedValue = null;
    var somma = [];
    var inputElements = document.getElementsByClassName('checkAnamesi');
    var anamnesi = document.getElementById('labelICD');
    for(var i=0; inputElements[i]; ++i){
        if(inputElements[i].checked){
            checkedValue = inputElements[i].value;
            somma.push(checkedValue);
        }
    }

    if (confirm('Eliminare questa/e patologia/e?') == true){
        $.post("formscripts/testoIcd.php",
            {
                anamnesi: anamnesi.value,
                radioEliminAnm: somma,
                id_anamFam: id_anam,
            },
            function(status){

                alert("Status: " + "Modifica effettuata");
                window.location.reload();

            }
        );
    }
}

/*
* Codifica ICD Spera-Magarelli.
* Funzione che abilita/disabilita i dati relativi il fumo durante l'aggiornamento
* dello stile di vita nell'anamnesi fisiologica
*/
function abilitaOpzioniFumo(index){
    if(index==1){
        $('#fumoQuantita').prop("disabled",false);
        $('#fumoAnnoInizio').prop("disabled",false);
        $('#fumoAnnoFine').prop("disabled",false);
    }
    if(index==0){
        $('#fumoQuantita').prop("disabled",true);
        $('#fumoAnnoInizio').prop("disabled",true);
        $('#fumoAnnoFine').prop("disabled",true);
        $('#fumoQuantita').prop('value', "");
        $('#fumoAnnoInizio').prop('value', "");
        $('#fumoAnnoFine').prop('value', "");
    }
    if(index==2){
        $('#fumoQuantita').prop("disabled",false);
        $('#fumoAnnoInizio').prop("disabled",false);
        $('#fumoAnnoFine').prop("disabled",true);
        $('#fumoAnnoFine').prop('value', "");
    }
}

/*
* Codifica ICD Spera-Magarelli.
* Funzione che abilita/disabilita i dati relativi l'alcool durante l'aggiornamento
* dello stile di vita nell'anamnesi fisiologica
*/
function abilitaOpzioniAlcool(index){
    if(index==1){
        $('#alcoolQuantita').prop("disabled",false);
        $('#alcoolAnnoInizio').prop("disabled",false);
        $('#alcoolAnnoFine').prop("disabled",false);
        $('#alcoolTipo').prop("disabled",false);
    }
    if(index==0){
        $('#alcoolQuantita').prop("disabled",true);
        $('#alcoolAnnoInizio').prop("disabled",true);
        $('#alcoolAnnoFine').prop("disabled",true);
        $('#alcoolTipo').prop("disabled",true);
        $('#alcoolQuantita').prop('value', "");
        $('#alcoolAnnoInizio').prop('value', "");
        $('#alcoolAnnoFine').prop('value', "");
        $('#alcoolTipo').prop('value', "");
    }
    if(index==2){
        $('#alcoolQuantita').prop("disabled",false);
        $('#alcoolAnnoInizio').prop("disabled",false);
        $('#alcoolAnnoFine').prop("disabled",true);
        $('#alcoolTipo').prop("disabled",false);
        $('#alcoolAnnoFine').prop('value', "");
    }
}

/*
* Codifica ICD Spera-Magarelli.
* Funzione che abilita/disabilita i dati relativi la droga durante l'aggiornamento
* dello stile di vita nell'anamnesi fisiologica
*/
function abilitaOpzioniDroga(index){
    if(index==1){
        $('#drogaQuantita').prop("disabled",false);
        $('#drogaAnnoInizio').prop("disabled",false);
        $('#drogaAnnoFine').prop("disabled",false);
        $('#drogaTipo').prop("disabled",false);
    }
    if(index==0){
        $('#drogaQuantita').prop("disabled",true);
        $('#drogaAnnoInizio').prop("disabled",true);
        $('#drogaAnnoFine').prop("disabled",true);
        $('#drogaTipo').prop("disabled",true);
        $('#drogaQuantita').prop('value', "");
        $('#drogaAnnoInizio').prop('value', "");
        $('#drogaAnnoFine').prop('value', "");
        $('#drogaTipo').prop('value', "");
    }
    if(index==2){
        $('#drogaQuantita').prop("disabled",false);
        $('#drogaAnnoInizio').prop("disabled",false);
        $('#drogaAnnoFine').prop("disabled",true);
        $('#drogaTipo').prop("disabled",false);
        $('#drogaAnnoFine').prop('value', "");
    }
}

/*
* Codifica ICD Spera-Magarelli.
* Funzione che abilita/disabilita i dati relativi il fumo,alcool e droga durante l'aggiornamento
* dello stile di vita nell'anamnesi fisiologica
*/
function settaOption(idQuantita,idAnnoInizio,idAnnoFine,idTipo,idSection){
    if ($(idSection)[0].selectedIndex==0){
        $(idQuantita).prop("disabled",true);
        $(idAnnoInizio).prop("disabled",true);
        $(idAnnoFine).prop("disabled",true);
        $(idTipo).prop("disabled",true);
    } else if ($(idSection)[0].selectedIndex==1){
        $(idQuantita).prop("disabled",false);
        $(idAnnoInizio).prop("disabled",false);
        $(idAnnoFine).prop("disabled",false);
        $(idTipo).prop("disabled",false);
    } else {
        $(idQuantita).prop("disabled",false);
        $(idAnnoInizio).prop("disabled",false);
        $(idAnnoFine).prop("disabled",true);
        $(idTipo).prop("disabled",false);
    }
}



