<?php

namespace App\Http\Controllers\Fhir;
/*

Nello standardi fhir gli OperationOutcome sono una collezione di errori
warning e informazioni relative ad una particolare operazione compiuta sul sistema.
Questa classe permette di generare la risorsa di un operationoutcome inserendo
come parametro un testo per aiutare il client a capire quali errori si sono presentati

https://www.hl7.org/fhir/operationoutcome.html

*/

class OperationOutcome {
    
    public function __construct() {}

    // metodo statico che permette di ottenere il codice XML della risorsa
    // OperationOutcome inserendo un testo come parametro

    public static function getXML($text) {

        $dom = new \DOMDocument('1.0', 'utf-8');

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
        $node_div->setAttribute('xmlns',"http://www.w3.org/1999/xhtml");
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