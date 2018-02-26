<?php

require_once("FHIRResource.php");

class Observation extends FHIRResource {
    public function __construct() {}

    function deleteResource($id) {
        if (empty(getInfo('id', 'indagini', 'id = ' . $id))) {
            throw new IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        # -----------------------------------------
        # ELIMINO I DATI DAL DATABASE

        $query_delete = 'DELETE FROM indagini WHERE id = "' . $id . '"';
        executeQuery($query_delete);

        // effettuo un nuovo controllo per verificare se la risorsa e' stata
        // effettivamente eliminata

        if (!empty(getInfo('id', 'indagini', 'id = ' . $id))) {
            throw new DeleteRequestRefusedException("can't delete resources with id provided");
        }
    }

    function updateResource($id, $xml) {
        $xml_values = simplexml_load_string($xml);
        $json = json_encode($xml_values);
        $array_data = json_decode($json, true);

        if (empty(getInfo('id', 'indagini', 'id = ' . $id))) {
            throw new IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        $db_values = array(
            'idpaziente' => '',
            'iddiagnosi' => '',
            'data' => '',
            'stato' => '',
            'tipo' => '',
            'motivo' => ''
        );

        # -----------------------------------------
        # PARSO I DATI DAL DOCUMENTO XML

        // controllo che l'id passato come URL coincida con il campo id della
        // risorsa xml passata come input

        if ($id != $array_data['id']['@attributes']['value']) {
            throw new MatchException('ID provided in url doesn\'t match the one in XML resource');
        }

        // prelevo l'id del paziente
        if (preg_match("/^\.\.\/fhir\/Patient\/(.*?)$/i", $array_data['subject']['reference']['@attributes']['value'], $matches)) {
            $db_values['idpaziente'] = $matches[1];
        } else {
            throw new InvalidResourceFieldException('invalid Patient id');
        }

        // prelevo l'id della diagnosi
        if (preg_match("/^\.\.\/fhir\/DiagnosticReport\/(.*?)$/i", $array_data['identifier']['value']['@attributes']['value'], $matches)) {
            $db_values['iddiagnosi'] = $matches[1];
        } else {
            throw new InvalidResourceFieldException('invalid diagnostic report id');
        }

        // prelevo la data
        if (!empty($array_data['effectiveDateTime']['@attributes']['value'])) {
            $db_values['data'] = $array_data['effectiveDateTime']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid date format');
        }

        // prelevo lo stato
        if (!empty($array_data['status']['@attributes']['value'])) {
            $temp_status = $array_data['status']['@attributes']['value'];

            switch($temp_status) {
                case 'final':
                    $db_values['stato'] = 'conclusa';
                    break;
                case 'registered':
                    $db_values['stato'] = 'richiesta';
                    break;
                case 'preliminary':
                    $db_values['stato'] = 'programmata';
                    break;
                default:
                    throw new InvalidResourceFieldException('invalid status code');
            }
        } else {
            throw new InvalidResourceFieldException('invalid status field');
        }

        // prelevo i campi delle estensioni
        foreach($array_data['extension'] as $extension_element) {
            switch ($extension_element['@attributes']['url']) {
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/observation-type.xml':
                    $db_values['tipo'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/observation-reason.xml';
                    $db_values['motivo'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                default:
                    throw new InvalidResourceFieldException('an extension is missing');
            }
        }

        //print_r($db_values);

        # -----------------------------------------
        # AGGIORNO I DATI PARSATI NEL DATABASE

        // query di inserimento che verra' eseguita
        $query_update = 'UPDATE indagini SET ' .
            'idpaziente = "' . $db_values['idpaziente'] . '", ' .
            'idDiagnosi = "' . $db_values['iddiagnosi'] . '", ' .
            'idStudioIndagini = "1", ' .
            'data = "' . $db_values['data'] . '", ' .
            'dataAggiornamento = "' . date('Y-m-d') . '", ' .
            'stato = "' . $db_values['stato'] . '", ' .
            'tipoIndagine = "' . $db_values['tipo'] . '", ' .
            'motivo = "' . $db_values['motivo'] . '" ' .
            'WHERE id = ' . $id;

        executeQuery($query_update);
    }

    function createResource($xml) {
        $xml_values = simplexml_load_string($xml);
        $json = json_encode($xml_values);
        $array_data = json_decode($json, true);

        //echo var_dump($array_data);

        $db_values = array(
            'idpaziente' => '',
            'iddiagnosi' => '',
            'data' => '',
            'stato' => '',
            'tipo' => '',
            'motivo' => ''
        );

        # -----------------------------------------
        # PARSO I DATI DAL DOCUMENTO XML

        if (!empty($array_data['id']['@attributes']['value'])) {
            throw new IdFoundInCreateException('invalid id specified in CREATE');
        }

        // prelevo l'id del paziente
        if (preg_match("/^\.\.\/fhir\/Patient\/(.*?)$/i", $array_data['subject']['reference']['@attributes']['value'], $matches)) {
            $db_values['idpaziente'] = $matches[1];
        } else {
            throw new InvalidResourceFieldException('invalid Patient id');
        }

        // prelevo l'id della diagnosi
        if (preg_match("/^\.\.\/fhir\/DiagnosticReport\/(.*?)$/i", $array_data['identifier']['value']['@attributes']['value'], $matches)) {
            $db_values['iddiagnosi'] = $matches[1];
        } else {
            throw new InvalidResourceFieldException('invalid diagnostic report id');
        }

        // prelevo la data
        if (!empty($array_data['effectiveDateTime']['@attributes']['value'])) {
            $db_values['data'] = $array_data['effectiveDateTime']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid date format');
        }

        // prelevo lo stato
        if (!empty($array_data['status']['@attributes']['value'])) {
            $temp_status = $array_data['status']['@attributes']['value'];

            switch($temp_status) {
                case 'final':
                    $db_values['stato'] = 'conclusa';
                    break;
                case 'registered':
                    $db_values['stato'] = 'richiesta';
                    break;
                case 'preliminary':
                    $db_values['stato'] = 'programmata';
                    break;
                default:
                    throw new InvalidResourceFieldException('invalid status code');
            }
        } else {
            throw new InvalidResourceFieldException('invalid status field');
        }

        // prelevo i campi delle estensioni
        foreach($array_data['extension'] as $extension_element) {
            switch ($extension_element['@attributes']['url']) {
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/observation-type.xml':
                    $db_values['tipo'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/observation-reason.xml';
                    $db_values['motivo'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                default:
                    throw new InvalidResourceFieldException('an extension is missing');
            }
        }

        //print_r($db_values);

        # -----------------------------------------
        # INSERISCO I DATI PARSATI NEL DATABASE

        $query_insert = 'INSERT INTO indagini (id, idpaziente, idDiagnosi, idStudioIndagini, data, stato, tipoIndagine, motivo) values (NULL, "' . $db_values['idpaziente'] . '", "' . $db_values['iddiagnosi'] . '", "1", "' . $db_values['data'] . '", "' . $db_values['stato'] . '", "' . $db_values['tipo'] . '", "'. $db_values['motivo'] . '")';

        executeQuery($query_insert);

        // prelevo l'id del campo con i valori appena inseriti
        $value_id = getInfo('id', 'indagini',
            'idpaziente = "' . $db_values['idpaziente'] . '" AND ' .
            'idDiagnosi = "' . $db_values['iddiagnosi'] . '" AND ' .
            'idStudioIndagini = "1" AND ' .
            'data = "' . $db_values['data'] . '" AND ' .
            'stato = "' . $db_values['stato'] . '" AND ' .
            'tipoIndagine = "'. $db_values['tipo'] . '" AND ' .
            'motivo = "'. $db_values['motivo'] . '"'
        );

        return $value_id;
    }
    
    function getResource($id)
    {
        if (empty(getInfo('id', 'indagini', 'id = ' . $id))) {
            throw new IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        //dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
        $indagine = "";
        
        //Recupero l' indagine diagnostica del paziente richiesta
        $indagine = getInfo('id','indagini','id='.$id);
        
        //dichiaro le variabili in modo tale che se non vi sono i relativi valori nel DB, il sistema non vada in crash
        $data = "";
        $stato = "";
        $tipoIndagine = "";
        $motivo = "";
        $idpaziente = "";
        $idcareprovider = "";
        $iddiagnosi = "";
        $statodiagnosi = "";
        $responso = "";
        $loincID = "";
        
        //Sec l' ID dell'indagine diagnostica non è vuoto recupero i valori richiesti dal DB
        if($indagine != null){
                $data = getInfo('data', 'indagini', 'id = ' . $indagine);
                $stato = getInfo('stato', 'indagini', 'id = ' . $indagine);
                $tipoIndagine = getInfo('tipoIndagine', 'indagini', 'id = ' . $indagine);
                $motivo = getInfo('motivo', 'indagini', 'id = ' . $indagine);
                $idpaziente = getInfo('idpaziente', 'indagini', 'id = ' . $indagine);
                $idcareprovider = getInfo('idcpp', 'indagini', 'id = ' . $indagine);
                $iddiagnosi = getInfo('idDiagnosi', 'indagini', 'id = ' . $indagine);
                $statodiagnosi = getInfo('stato', 'diagnosi', 'id = ' . $iddiagnosi);
                $responso = getInfo('responso', 'diagnosi', 'id = ' . $iddiagnosi);
                $loincID = getInfo('loincID', 'indagini', 'id = ' . $indagine);
        }
        
        //recupero il codice dell'indagine secondo la codifica LOINC e il suo valore testuale
        $codice_loinc = "";
        $codice_visualizzabile_loinc = "";
        if($loincID!="")
        {
            $codice_loinc = getInfo('LOINC_NUM', 'loinc', 'ID = ' . $loincID);
            $codice_visualizzabile_loinc = getInfo('COMPONENT', 'loinc', 'ID = ' . $loincID);
        }
        


        //Creazione del documento XML per l'indagine diagnostica
        //Creazione di un oggetto dom con la codifica UTF-8
        $dom = new DOMDocument('1.0', 'utf-8');
        
        //Creazione del nodo Observation, cioè il nodo Root  della risorsa
        $Observation = $dom->createElement('Observation');
        //Valorizzo il namespace della risorsa e del documento XML, in  questo caso la specifica FHIR
        $Observation->setAttribute('xmlns', 'http://hl7.org/fhir');
        $Observation = $dom->appendChild($Observation);
        
        
        //Creazione del nodo ID sempre presente nelle risorse FHIR
        $id = $dom->createElement('id');
        //Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
        $id->setAttribute('value', $indagine);
        $id = $Observation->appendChild($id);
        
        
        //Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
        $narrative = $dom->createElement('text');
        $narrative = $Observation->appendChild($narrative);
        
        
        //Creazione del nodo status che indica lo stato della parte narrativa
        $status = $dom->createElement('status');
        //Il valore del nodo status è sempre generated, la parte narrativa è generato dal sistema
        $status->setAttribute('value', 'generated');
        $status = $narrative->appendChild($status);
        
        
        //Creazione del div che conterrà la tabella con i valori visualizzabili nella parte narrativa
        $div = $dom->createElement('div');
        //Link al value set della parte narrativa, cioè la codifica XHTML
        $div->setAttribute('xmlns',"http://www.w3.org/1999/xhtml");
        $div = $narrative->appendChild($div);
        
        
        //Creazione della tabella che conterrà i valori
        $table = $dom->createElement('table');
        $table->setAttribute('border',"2");
        $table = $div->appendChild($table);
        
        
        //Creazione del nodo tbody
        $tbody = $dom->createElement('tbody');
        $tbody = $table->appendChild($tbody);
        
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        
        //Creazione della colonna Date
        $td = $dom->createElement('td',"Date");
        $td = $tr->appendChild($td);
        
        
        //Creazione della colonna con il valore di data
        $td = $dom->createElement('td', $data);
        $td = $tr->appendChild($td);
        
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr =$tbody->appendChild($tr);
        
        
        //Creazione della colonna state
        $td = $dom->createElement('td',"State");
        $td = $tr->appendChild($td);
        
        
        //Creazione della colonna con il valore dello stato della diagnosi
        if($stato=="conclusa")
            $td = $dom->createElement('td','final');
        elseif($stato=="richiesta")
            $td = $dom->createElement('td','registered');
        elseif($stato=="programmata")
            $td = $dom->createElement('td','preliminary');
        $td = $tr->appendChild($td);
        
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        
        //Creazione della colonna Type
        $td = $dom->createElement('td',"Type");
        $td = $tr->appendChild($td);
        
        
        //Creazione della colonna con il valore di tipo di indagine diagnositca
        $td = $dom->createElement('td',$tipoIndagine);
        $td = $tr->appendChild($td);    
        
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        
        //Creazione della colonna Reason
        $td = $dom->createElement('td',"Reason");
        $td = $tr->appendChild($td);
        
        
        //Creazione della colonna con il valore del motivo per cui è stata richiesta un'indagine diagnostica
        $td = $dom->createElement('td',$motivo);
        $td = $tr->appendChild($td);    
        
        // creazione del nodo dell'extension del tipo indagine
        $node_extension_type = $dom->createElement('extension');
        $node_extension_type->setAttribute('url', 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/observation-type.xml');
        $node_extension_type = $Observation->appendChild($node_extension_type);

        $node_valueString = $dom->createElement('valueString');
        $node_valueString->setAttribute('value', $tipoIndagine);
        $node_valueString = $node_extension_type->appendChild($node_valueString);

        // creazione del nodo dell'extension del motivo
        $node_extension_reason = $dom->createElement('extension');
        $node_extension_reason->setAttribute('url', 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/observation-reason.xml');
        $node_extension_reason = $Observation->appendChild($node_extension_reason);

        $node_valueString = $dom->createElement('valueString');
        $node_valueString->setAttribute('value', $motivo);
        $node_valueString = $node_extension_reason->appendChild($node_valueString);
        
        //Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
        $identifier = $dom->createElement('identifier');
        $identifier = $Observation->appendChild($identifier);
        //Creazione del nodo use con valore fisso ad usual
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'usual');
        $use = $identifier->appendChild($use);
        //Creazione del nodo system che identifica il namespace degli URI per identificare la risorsa
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'urn:ietf:rfc:3986'); //RFC gestione URI
        $system = $identifier->appendChild($system);
        //Creazione del nodo value
        $value = $dom->createElement('value');
        //Do il valore all' URI della risorsa
        $value->setAttribute('value', "../fhir/DiagnosticReport/".$iddiagnosi);
        $value = $identifier->appendChild($value);
        
        
        //Creazione del nodo status per indicare lo stato dell'indagine fra conclusa, richiesta e programmata, tradotta secondo lo standards
        $status = $dom->createElement('status');
        //Do il valore all' attributo del tag
        if($stato=="conclusa")
            $status->setAttribute('value', 'final');
        elseif($stato=="richiesta")
            $status->setAttribute('value', 'registered');
        elseif($stato=="programmata")
            $status->setAttribute('value', 'preliminary');  
        $status = $Observation->appendChild($status);   
        
        
        //Creazione del nodo category indicante una classificazione dell'indagine
        $category = $dom->createElement('category');
        $category = $Observation->appendChild($category);
        //Creazione del nodo coding
        $coding = $dom->createElement('coding');
        $coding = $category->appendChild($coding);
        //Creazione del nodo system con il valore del value set fornito da HL7
        $system = $dom->createElement('system');
        //Do il valore all' attributo del tag
        $system->setAttribute('value', 'http://hl7.org/fhir/observation-category');
        $system = $coding->appendChild($system);
        //Creazione del nodo code settato sempre a exam in quanto l'indagine risulta 
        //essere risultato di un esame  fisico o osservazione da parte di un careprovider
        $code = $dom->createElement('code');
        $code ->setAttribute('value', 'exam');
        $code = $coding->appendChild($code);
        //Creazione del nodo display che indica il valore da visualizzare
        $display = $dom->createElement('display');
        $display->setAttribute('value', 'Exam');
        $display = $coding->appendChild($display);
        
        if($loincID!="")
        {
            //Creazione del nodo code indicante il codice secondo la codifica LOINC dell' indagine
            $code = $dom->createElement('code');
            $code = $Observation->appendChild($code);
            //Creazione del nodo coding
            $coding = $dom->createElement('coding');
            $coding = $code->appendChild($coding);
            //Creazione del nodo system che indica il value set LOINC
            $system = $dom->createElement('system');
            $system->setAttribute('value', 'http://loinc.org');
            $system = $coding->appendChild($system);
            //Creazione del nodo code che indica il valore dell'indagine
            $code = $dom->createElement('code');
            $code ->setAttribute('value', $codice_loinc);
            $code = $coding->appendChild($code);
            //Creazione del nodo display che indica il valore del codice dell' indagine da visualizzare
            $display = $dom->createElement('display');
            $display->setAttribute('value', $codice_visualizzabile_loinc);
            $display = $coding->appendChild($display);
        }
        
        //Creazione del nodo subject indicante il paziente sottoposto all'indagine diagnostica
        $subject = $dom->createElement('subject');
        $subject = $Observation->appendChild($subject);
        //Creazione del nodo reference come referenziazione alla risorsa
        $reference = $dom->createElement('reference');
        $reference->setAttribute('value', "../fhir/Patient/".$idpaziente);
        $reference = $subject->appendChild($reference);
        
        
        //Creazione del nodo effectiveDateTime indicante la data di effettuazione dell'osservazione
        $effectiveDateTime = $dom->createElement('effectiveDateTime');
        $effectiveDateTime->setAttribute('value', $data);
        $effectiveDateTime = $Observation->appendChild($effectiveDateTime);
        
        
        //Genero la data dalla quale è disponibile l'indagine secondo lo standard ATOM ISO-8601
        $datetime = new DateTime($data);
        //Creazione del nodo issued indicante la data dalla quale è disponibile l'indagine che corrisponde alla data di creazione
        $issued = $dom->createElement('issued');
        $issued->setAttribute('value', $datetime->format(DateTime::ATOM));
        $issued = $Observation->appendChild($issued);
        
        
        //Creazione del nodo performer indicante il care provider che ha eseguito l'indagine diagnostica
        $performer = $dom->createElement('performer');
        $performer = $Observation->appendChild($performer);
        //Creazione del nodo reference come referenziazione alla risorsa
        $reference = $dom->createElement('reference');
        $reference->setAttribute('value', "../fhir/Practitioner/".$idcareprovider);
        $reference = $performer->appendChild($reference);
        
        
        //Inserisco il responso dell'osservazione solo se lo stato dell'indagine è concluso e si conosce il responso stesso
        if($stato=="conclusa" && $responso!=""){
            //Creazione del nodo valueString indicante il responso
            $valueString = $dom->createElement('valueString');
            $valueString->setAttribute('value', $responso);
            $valueString = $Observation->appendChild($valueString);
        }
        //in altrimenti se lo stato non è concluso inserisco che il responso manca perchè deve finire l'indagine
        elseif($stato=="richiesta" || $stato=="programmata"){
            //Creazione del nodo interpretation indicante il motivo per il quale manca il responso
            $dataAbsentReason = $dom->createElement('dataAbsentReason');
            $dataAbsentReason = $Observation->appendChild($dataAbsentReason);
            //Creazione del nodo coding
            $coding = $dom->createElement('coding');
            $coding = $dataAbsentReason->appendChild($coding);
            //Creazione del nodo system per il value set da cui recuperare i valori HL7
            $system = $dom->createElement('system');
            $system->setAttribute('value', "http://hl7.org/fhir/data-absent-reason");
            $system = $coding->appendChild($system);
            //Creazione del nodo code
            $code = $dom->createElement('code');
            //Do il valore all' attributo del tag al valore fisso temp, che indica in attesa di completamento
            $code->setAttribute('value', "temp");
            $code = $coding->appendChild($code);
            //Creazione del nodo display per la visualizzazione del stato
            $display = $dom->createElement('display');
            //Do il valore all' attributo del tag
            $display->setAttribute('value', "Temp");
            $display = $coding->appendChild($display);
        }
        //in altrimenti se lo stato è concluso ma non si conosce il responso si usa unknown
        elseif($responso=="" && $stato=="conclusa"){
            //Creazione del nodo interpretation indicante il motivo per il quale manca il responso
            $dataAbsentReason = $dom->createElement('dataAbsentReason');
            $dataAbsentReason = $Observation->appendChild($dataAbsentReason);
            //Creazione del nodo coding
            $coding = $dom->createElement('coding');
            $coding = $dataAbsentReason->appendChild($coding);
            //Creazione del nodo system per il value set da cui recuperare i valori HL7
            $system = $dom->createElement('system');
            $system->setAttribute('value', "http://hl7.org/fhir/data-absent-reason");
            $system = $coding->appendChild($system);
            //Creazione del nodo code
            $code = $dom->createElement('code');
            //Do il valore all' attributo del tag al valore fisso unknow, che indica che non si conosce
            $code->setAttribute('value', "unknown");
            $code = $coding->appendChild($code);
            //Creazione del nodo display per la visualizzazione del stato
            $display = $dom->createElement('display');
            //Do il valore all' attributo del tag
            $display->setAttribute('value', "Unknown");
            $display = $coding->appendChild($display);
        }
        
        
        //Creazione del nodo interpretation indicante un'interpretazione del responso
        $interpretation = $dom->createElement('interpretation');
        $interpretation = $Observation->appendChild($interpretation);
        //Creazione del nodo coding
        $coding = $dom->createElement('coding');
        $coding = $interpretation->appendChild($coding);
        //Creazione del nodo system per il value set da cui recuperare i valori HL7
        $system = $dom->createElement('system');
        $system->setAttribute('value', "http://hl7.org/fhir/v2/0078");
        $system = $coding->appendChild($system);
        //Creazione del nodo code
        $code = $dom->createElement('code');
        //Do il valore all' attributo del tag in base allo stato della diagnosi
        if($statodiagnosi=="0")
            $code->setAttribute('value', "POS");
        elseif($statodiagnosi=="1")
            $code->setAttribute('value', "IE");
        elseif($statodiagnosi=="2")
            $code->setAttribute('value', "NEG");
        $code = $coding->appendChild($code);
        //Creazione del nodo display per la visualizzazione del stato
        $display = $dom->createElement('display');
        //Do il valore all' attributo del tag
        if($statodiagnosi=="0")
            $display->setAttribute('value', "Confermata");
        elseif($statodiagnosi=="1")
            $display->setAttribute('value', "Sospetta");
        elseif($statodiagnosi=="2")
            $display->setAttribute('value', "Esclusa");
        $display = $coding->appendChild($display);


        //Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
        $dom->preserveWhiteSpace = false;
        //Formattazione per l'output
        $dom->formatOutput = true;
        //Salvo il documento XML nella cartella rsources dando come nome, l'id del paziente
        //$dom->save("Observation/".$indagine.".xml");
        
        return $dom->saveXML();
    }
}

?>