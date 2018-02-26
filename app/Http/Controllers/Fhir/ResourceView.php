<?php

// Classe che dispone di metodi per visualizzare la risorsa

class ResourceView {
    public function __construct() {
    }

    // il metodo se viene chiamato stampa il contenuto in formato xml o json
    // se non e' riconosciuto alcun formato allora stampo un messaggio di errore
    public function display_raw($resource_content, $format = 'xml') {
        if ($format == 'xml') {
            // cambio gli header della risposta che il server manda al client
            // e ritorno la risorsa sottoforma di raw XML
            header('Content-Type: application/xml+fhir; charset=utf-8');

            // specifico in questo header che se il browser sa come renderizzare la pagina
            // allora la deve mostrare nel browser, altrimenti deve salvarla sotto forma di file
            // specificando il nome in filename
            header('Content-Disposition: inline; filename=risorsa_' . md5(time()) . '.xml');
        
            echo $resource_content;
        } else if ($format == 'json') {
            // per uno svilupo futuro si puo' inserire in questo blocco
            // la conversione della risorsa da xml a json in maniera server side
            header('Content-Type: application/json+fhir; charset=utf-8');
            header('Content-Disposition: inline; filename=risorsa_' . md5(time()) . '.json');

            $bourne = 'json'; // :D

            echo "{\r\n  \"resourceType\": \"OperationOutcome\",\r\n  \"issue\": [\r\n    {\r\n      \"severity\": \"error\",\r\n      \"diagnostics\": \"$bourne not supported server side\",\r\n      \"code\": \"invalid\"\r\n    }\r\n  ]\r\n}";
        } else if ($format == 'html') {
            // a differenza degli altri formati, se il formato specificato e' html
            // allora visualizzero' nella pagina del browser solo il contenuto narrativo
            // composto dalle tabelle del codice xhtml. Non viene quindi modificato il content-type

            header('Content-Disposition: inline; filename=risorsa_' . md5(time()) . '.xhtml');
            echo $resource_content;
        } else {
            // stampo l'errore in formato html quindi metto tipo e id della risorsa vuoti
            $this->display_html('', '',
                OperationOutcome::getXML("specified format not found"), true);
            
            // se non ci sono altri formati riconosciuti ritorno un errore di
            // tipo bad request e termino lo script
            http_response_code(400);
            exit();
        }
    }

    public function display_html($resource_type, $resource_id, $resource_content, $is_error = false) {
        // se e' stato impostato a true il flag per la visualizzazione
        // dell'errore allora cambio il resource type con l'operation outcome
        if ($is_error) {
            $resource_type = 'OperationOutcome';
            $resource_id = '';
        }

        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="http://'.$_SERVER['HTTP_HOST'].'/resources/assets/faviconFSEM-FHIR.ico">
    <title>FHIR API &bull; '.$resource_type.'</title>
    
    <link rel="stylesheet" href="http://'.$_SERVER['HTTP_HOST'].'/resources/assets/gruvbox-dark.min.css">
    <link rel="stylesheet" href="http://'.$_SERVER['HTTP_HOST'].'/resources/assets/font-awesome/css/font-awesome.min.css">
    <script src="http://'.$_SERVER['HTTP_HOST'].'/resources/assets/highlight.min.js"></script>
    <script src="http://'.$_SERVER['HTTP_HOST'].'/resources/assets/clipboard.min.js"></script>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
</head>
<body>
    <script>hljs.initHighlightingOnLoad(); new Clipboard(\'.btn\');</script>
    <h1>FSEM FHIR API &bull; <font color="orange">'.$resource_type.'</font>';

        // se la pagina si riferisce ad un errore allora non mostro l'id della risorsa nell'h1
        if (!$is_error) {
            echo ' &bull; <font color="red">'.$resource_id.'</font>';
        }

        echo '</h1>';

        // visualizzo la risorsa con un syntax highlighter e dei pulsanti per copiare il
        // contenuto nella clipboard, validare la risorsa, cambiare il formato della risorsa

        if ($is_error) {
            echo "<pre style='
            width: 70%;
            resize: both;
            font-size: 15px;
            overflow: auto;'>";
        } else {
            echo "<pre style='border: 1px solid;
            width: 70%;
            height: 370px;
            resize: both;
            font-size: 15px;
            overflow: auto;'>";
        }

        echo "<code id='codeelem' class='xml'>".htmlspecialchars($resource_content)."</code></pre>
            <button class='btn' data-clipboard-target='#codeelem' style='border-radius: 3px; background-color: #eee; background-image: linear-gradient(#fcfcfc,#eee); '>
            <i class=\"fa fa-clipboard fa-2x\" aria-hidden=\"true\"></i> <font size='4'>Copia nella clipboard</font>
            </button>&nbsp;
            <button onclick='convert()' class='btn' style='border-radius: 3px; background-color: #eee; background-image: linear-gradient(#fcfcfc,#eee); '>
            <i class=\"fa fa-exchange fa-2x\" aria-hidden=\"true\"></i> <font size='4'><span id='convert_button_text'>Converti in JSON</span></font>
            </button>&nbsp;
            <a href=\"http://fhir3.healthintersections.com.au/open\" target='_blank'><button class='btn' style='border-radius: 3px; background-color: #eee; background-image: linear-gradient(#fcfcfc,#eee); '>
            <i class=\"fa fa-check-circle fa-2x\" aria-hidden=\"true\"></i> <font size='4'>Validazione risorsa</font>
            </button></a>";

        // se la pagina e' un errore allora non mostro il pulsante di download della risorsa
        if (!$is_error) {
            echo "&nbsp;
            <a href=\"http://".$_SERVER['HTTP_HOST']."/fhir/".$resource_type."/".$resource_id."?_format=xml\"><button class='btn' style='border-radius: 3px; background-color: #eee; background-image: linear-gradient(#fcfcfc,#eee); '>
            <i class=\"fa fa-download fa-2x\" aria-hidden=\"true\"></i> <font size='4'>Download file XML</font>
            </button></a>";
        }

        // includo gli script che mi permettono di convertire la risorsa fhir da XML a JSON
        // per fare cio' utilizzo un interprete in linguaggio Lua scritto in javascript,
        // questo perche' il traduttore della risorsa fhir e' scritto in Lua.
        // https://github.com/vadi2/fhir-formats
        echo '
        <script src="http://'.$_SERVER['HTTP_HOST'].'/resources/assets/fhirformats/lua.vm.js"></script>
        <script type="text/lua">
        -- has to be a global
        in_fhir_json = require("http://'.$_SERVER['HTTP_HOST'].'/resources/assets/fhirformats/fhirformats.web.lua").to_json
        in_fhir_xml = require("http://'.$_SERVER['HTTP_HOST'].'/resources/assets/fhirformats/fhirformats.web.lua").to_xml
        -- warm up FHIR resources cache
        in_fhir_xml\'{}\'
        </script>
        <script src="http://'.$_SERVER['HTTP_HOST'].'/resources/assets/fhirformats/converter.js" charset="utf-8"></script>';

    echo '</body>
</html>';
    }
}

?>