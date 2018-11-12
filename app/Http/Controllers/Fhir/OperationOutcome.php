<?php
namespace App\Http\Controllers\Fhir;
/*
 *
 * Nello standardi fhir gli OperationOutcome sono una collezione di errori
 * warning e informazioni relative ad una particolare operazione compiuta sul sistema.
 * Questa classe permette di generare la risorsa di un operationoutcome inserendo
 * come parametro un testo per aiutare il client a capire quali errori si sono presentati
 *
 * https://www.hl7.org/fhir/operationoutcome.html
 *
 */

use View;
use Illuminate\Filesystem\Filesystem;
use File;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Exception;
use DB;
use Redirect;
use Response;
use SimpleXMLElement;
use DOMDocument;
use ZipArchive;

class OperationOutcome
{
    
    
    // il metodo se viene chiamato stampa il contenuto in formato xml o json
    // se non e' riconosciuto alcun formato allora stampo un messaggio di errore
    public static function display_raw($resource_content, $format = 'xml') {
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
            
            header('Content-Disposition: inline; filename=risorsa_' . md5(time()) . '.json');
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
    

    // metodo statico che permette di ottenere il codice XML della risorsa
    // OperationOutcome inserendo un testo come parametro
    public static function getXML($text)
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $node_operationoutcome = $dom->createElement('OperationOutcome');
        $node_operationoutcome->setAttribute('xmlns', 'http://hl7.org/fhir');
        $node_operationoutcome = $dom->appendChild($node_operationoutcome);
        
        // parte narrativa
        
        $node_narrative = $dom->createElement('text');
        $node_narrative = $node_operationoutcome->appendChild($node_narrative);
        
        $node_status = $dom->createElement('status');
        $node_status->setAttribute('value', 'generated');
        $node_status = $node_narrative->appendChild($node_status);
        
        $node_div = $dom->createElement('div');
        $node_div->setAttribute('xmlns', "http://www.w3.org/1999/xhtml");
        $node_div = $node_narrative->appendChild($node_div);
        
        $node_h1 = $dom->createElement('h1', $text);
        $node_h1 = $node_div->appendChild($node_h1);
        
        // parte struttura
        
        $node_issue = $dom->createElement('issue');
        $node_issue = $node_operationoutcome->appendChild($node_issue);
        
        $node_serverity = $dom->createElement('severity');
        $node_serverity->setAttribute('value', 'error');
        $node_serverity = $node_issue->appendChild($node_serverity);
        
        $node_code = $dom->createElement('code');
        $node_code->setAttribute('value', 'invalid');
        $node_code = $node_issue->appendChild($node_code);
        
        $node_diagnostics = $dom->createElement('diagnostics');
        $node_diagnostics->setAttribute('value', $text);
        $node_diagnostics = $node_issue->appendChild($node_diagnostics);
        
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        
        return $dom->saveXML();
    }
}

?>