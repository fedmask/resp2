<?php

require_once("FHIRResource.php");

class DiagnosticReport extends FHIRResource {
	public function __construct() {}

    function deleteResource($id) {
        if (empty(getInfo('id', 'diagnosi', 'id = ' . $id))) {
            throw new IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        # -----------------------------------------
        # ELIMINO I DATI DAL DATABASE

        $query_delete = 'DELETE FROM diagnosi WHERE id = \'' . $id . '\'';
        executeQuery($query_delete);

        $query_delete = 'DELETE FROM careproviderdiagnosi WHERE diagnosi_id = \'' . $id . '\'';
        executeQuery($query_delete);

        // effettuo un nuovo controllo per verificare se la risorsa e' stata
        // effettivamente eliminata

        if (!empty(getInfo('id', 'diagnosi', 'id = ' . $id)) || !empty(getInfo('id', 'diagnosi', 'id = ' . $id))) {
            throw new DeleteRequestRefusedException("can't delete resources with id provided");
        }
    }

	function updateResource($id, $xml) {
        $xml_values = simplexml_load_string($xml);
        $json = json_encode($xml_values);
        $array_data = json_decode($json, true);

        if (empty(getInfo('id', 'diagnosi', 'id = ' . $id))) {
            throw new IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        //echo var_dump($array_data);

        $db_values = array(
            'idpaziente' => '',
            'dataInserimento' => '',
            'patologia' => '',
            'stato' => '',
            'careprovider' => '',
            'idcpp' => ''
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

        // prelevo l'id del care provider
        if (preg_match("/^\.\.\/fhir\/Practitioner\/(.*?)$/i", $array_data['performer']['reference']['@attributes']['value'], $matches)) {
            $db_values['idcpp'] = $matches[1];
        } else {
            throw new InvalidResourceFieldException('invalid Care provider id');
        }

        if (!empty($array_data['effectiveDateTime']['@attributes']['value'])) {
            $db_values['dataInserimento'] = $array_data['effectiveDateTime']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid entry date field');
        }

        if (!empty($array_data['conclusion']['@attributes']['value'])) {
            $db_values['patologia'] = $array_data['conclusion']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid conclusion field');
        }

        if ($array_data['extension']['@attributes']['url'] == 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/diagnosticreport-status.xml') {
            $db_values['stato'] = $array_data['extension']['valueString']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid extension for status');
        }

        $db_values['careprovider'] = getInfo('nome', 'careproviderpersona', 'id = ' . $db_values['idcpp']) . ' ' . getInfo('cognome', 'careproviderpersona', 'id = ' . $db_values['idcpp']);

        // print_r($db_values);

        # -----------------------------------------
        # AGGIORNO I DATI PARSATI NEL DATABASE

        $query_update = 'UPDATE diagnosi SET ' .
            'idpaziente = "' . $db_values['idpaziente'] . '", ' .
            'dataIns = "' . $db_values['dataInserimento'] . '", ' .
            'dataAgg = "' . date('Y-m-d H:i:s') . '", ' .
            'patologia = "' . $db_values['patologia'] . '", ' .
            'stato = "' . $db_values['stato'] . '", ' .
            'conf = "1", ' .
            'dataguarigione = "0000-00-00"' .
            'WHERE id = ' . $id;

        executeQuery($query_update);

        // aggiorno i valori anche della seconda tabella

        $query_update = 'UPDATE careproviderdiagnosi SET ' .
            'statoDiagnosi = "' . $db_values['stato'] . '", ' .
            'careprovider = "' . $db_values['careprovider'] . '", ' .
            'idcpp = "' . $db_values['idcpp'] . '" ' .
            'WHERE diagnosi_id = ' . $id;

        executeQuery($query_update);
    }

	function createResource($xml) {
		$xml_values = simplexml_load_string($xml);
        $json = json_encode($xml_values);
        $array_data = json_decode($json, true);

        //echo var_dump($array_data);

        $db_values = array(
            'idpaziente' => '',
            'dataInserimento' => '',
            'patologia' => '',
            'stato' => '',
            'careprovider' => '',
            'idcpp' => ''
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

        // prelevo l'id del care provider
        if (preg_match("/^\.\.\/fhir\/Practitioner\/(.*?)$/i", $array_data['performer']['reference']['@attributes']['value'], $matches)) {
            $db_values['idcpp'] = $matches[1];
        } else {
            throw new InvalidResourceFieldException('invalid Care provider id');
        }

        if (!empty($array_data['effectiveDateTime']['@attributes']['value'])) {
        	$db_values['dataInserimento'] = $array_data['effectiveDateTime']['@attributes']['value'];
        } else {
        	throw new InvalidResourceFieldException('invalid entry date field');
        }

        if (!empty($array_data['conclusion']['@attributes']['value'])) {
        	$db_values['patologia'] = $array_data['conclusion']['@attributes']['value'];
        } else {
        	throw new InvalidResourceFieldException('invalid conclusion field');
        }

        if ($array_data['extension']['@attributes']['url'] == 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/diagnosticreport-status.xml') {
        	$db_values['stato'] = $array_data['extension']['valueString']['@attributes']['value'];
        } else {
        	throw new InvalidResourceFieldException('invalid extension for status');
        }

        $db_values['careprovider'] = getInfo('nome', 'careproviderpersona', 'id = ' . $db_values['idcpp']) . ' ' . getInfo('cognome', 'careproviderpersona', 'id = ' . $db_values['idcpp']);

        //print_r($db_values);

        # -----------------------------------------
        # INSERISCO I DATI PARSATI NEL DATABASE

        $query_insert = 'INSERT INTO diagnosi (id, idpaziente, dataIns, dataAgg, patologia, stato, conf, dataguarigione) values (NULL, "' . $db_values['idpaziente'] . '", "' . $db_values['dataInserimento'] . '", "'. $db_values['dataInserimento'] .'", "' . $db_values['patologia'] . '", "' . $db_values['stato'] . '", "1", "0000-00-00")';

        executeQuery($query_insert);

        // prelevo l'id del campo con i valori appena inseriti
        $value_id = getInfo('id', 'diagnosi',
            'idpaziente = "' . $db_values['idpaziente'] . '" AND ' .
            'dataIns = "' . $db_values['dataInserimento'] . '" AND ' .
            'dataAgg = "'. $db_values['dataInserimento'].'" AND ' .
            'patologia = "' . $db_values['patologia'] . '" AND ' .
            'stato = "' . $db_values['stato'] . '" AND ' .
            'conf = "1" AND ' .
            'dataguarigione = "0000-00-00"'
        );

        // inserisco anche nella tabella careproviderdiagnosi

        $query_insert = 'INSERT INTO careproviderdiagnosi (diagnosi_id, statoDiagnosi, careprovider, idcpp) values ("'.$value_id.'", "'.$db_values['stato'].'", "'.$db_values['careprovider'].'", "'.$db_values['idcpp'].'")';

        executeQuery($query_insert);

        return $value_id;
	}

	function getResource($id)
	{
		//Recupero il Report Diagnostico richiesto  dall' ID del report
		$diagnosi = $id;

        if (empty(getInfo('id', 'diagnosi', 'id = ' . $id))) {
            throw new IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
		
		//dichiaro le variabili in modo tale che se non vi sono i relativi valori nel DB, il sistema non vada in crash
		$idpaziente = "";
		$datains = "";
		$dataagg = "";
		$patologia = "";
		$stato = "";
		$conf = "";
		$idcareprovider = "";
		$careproviderdiagnosi = "";
		$statodiagnosi = "";
		$idindagine = "";
		$nindagini = "";
		$loincID = "";
		
		//Se l'ID passato non è vuoto recupero le informazioni necessari dalla specifica dal DB
		if($diagnosi != null){
			$idpaziente = getInfo('idPaziente', 'diagnosi', 'id = ' . $diagnosi);
			$datains = getInfo('dataIns', 'diagnosi', 'id = ' . $diagnosi);
			$dataagg = getInfo('dataAgg', 'diagnosi', 'id = ' . $diagnosi);
			$patologia = getInfo('patologia', 'diagnosi', 'id = ' . $diagnosi);
			$stato = getInfo('stato', 'diagnosi', 'id = ' . $diagnosi);
			$conf = getInfo('conf', 'diagnosi', 'id = ' . $diagnosi);
			$idcareprovider = getInfo('idcpp', 'careproviderdiagnosi', 'diagnosi_id = ' . $diagnosi);
			$careproviderdiagnosi = getInfo('careprovider', 'careproviderdiagnosi', 'diagnosi_id = ' . $diagnosi);
			$statodiagnosi = getInfo('statoDiagnosi', 'careproviderdiagnosi', 'diagnosi_id = ' . $diagnosi);
			$idindagine = getArray('id', 'indagini', 'idDiagnosi = ' . $diagnosi);	
			$nindagini = count($idindagine);
			$loincID = getInfo('loincID', 'diagnosi', 'id = ' . $diagnosi);
		}
		
		//recupero il codice della diagnosi secondo la codifica LOINC e il suo valore testuale
		$codice_loinc = "";
		$codice_visualizzabile_loinc = "";
		if($loincID!="")
		{
			$codice_loinc = getInfo('LOINC_NUM', 'loinc', 'ID = ' . $loincID);
			$codice_visualizzabile_loinc = getInfo('COMPONENT', 'loinc', 'ID = ' . $loincID);
		}
		
		
		//Creazione del documento XML per il report diagnostico
		//Creazione di un oggetto dom con la codifica UTF-8
		$dom = new DOMDocument('1.0', 'utf-8');
		
		//Creazione del nodo Practitioner, cioè il nodo Root  della risorsa
		$DiagnosticReport = $dom->createElement('DiagnosticReport');
		//Valorizzo il namespace della risorsa e del documento XML, in  questo caso la specifica FHIR
		$DiagnosticReport->setAttribute('xmlns', 'http://hl7.org/fhir');
		//Corrello l'elemento con il nodo superiore
		$DiagnosticReport = $dom->appendChild($DiagnosticReport);
		
		
		//Creazione del nodo ID sempre presente nelle risorse FHIR
		$id = $dom->createElement('id');
		//Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
		$id->setAttribute('value', $diagnosi);
		$id = $DiagnosticReport->appendChild($id);
		
		
		//Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
		$narrative = $dom->createElement('text');
		//Corrello l'elemento con il nodo superiore
		$narrative = $DiagnosticReport->appendChild($narrative);
		
		
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
		$td = $dom->createElement('td', $datains);
		$td = $tr->appendChild($td);
		
		
		
		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr =$tbody->appendChild($tr);
		
		
		//Creazione della colonna Pathology
		$td = $dom->createElement('td',"Pathology");
		$td = $tr->appendChild($td);
		
		
		//Creazione della colonna con il valore della patologia
		$td = $dom->createElement('td',$patologia);
		$td = $tr->appendChild($td);
		
		
		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr =$tbody->appendChild($tr);
		
		
		//Creazione della colonna stato
		$td = $dom->createElement('td',"State");
		$td = $tr->appendChild($td);
		
		
		//Creazione della colonna con il valore dello stato della diagnosi
		$td = $dom->createElement('td',$stato);
		$td = $tr->appendChild($td);
		 
		// creazione del nodo dell'extension
        $node_extension_status = $dom->createElement('extension');
        $node_extension_status->setAttribute('url', 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/diagnosticreport-status.xml');
        $node_extension_status = $DiagnosticReport->appendChild($node_extension_status);

        $node_valueString = $dom->createElement('valueString');
        $node_valueString->setAttribute('value', $stato);
        $node_valueString = $node_extension_status->appendChild($node_valueString);
		
		//Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
		$identifier = $dom->createElement('identifier');
		$identifier = $DiagnosticReport->appendChild($identifier);
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
		$value->setAttribute('value', "../fhir/DiagnosticReport/".$diagnosi);
		$value = $identifier->appendChild($value);
		
		
		//Creazione del nodo statusn settato sempre a final in quanto il report è completo
		$status = $dom->createElement('status');
		$status->setAttribute('value', 'final');
		$status = $DiagnosticReport->appendChild($status);
		
		
		if($loincID!="")
		{
			//Creazione del nodo code indicante il codice del report diagnostico secondo la codifica LOINC
			$code = $dom->createElement('code');
			$code = $DiagnosticReport->appendChild($code);
			//Creazione del nodo coding
			$coding = $dom->createElement('coding');
			$coding = $code->appendChild($coding);
			//Creazione del nodo system in cui si indica il value set della codifica LOINC
			$system = $dom->createElement('system');
			$system->setAttribute('value', 'http://loinc.org');
			$system = $coding->appendChild($system);
			//Creazione del nodo code indicante il codice del report
			$code = $dom->createElement('code');
			$code ->setAttribute('value', $codice_loinc);
			$code = $coding->appendChild($code);
			//Creazione del nodo display indicante il valore da visualizzare relativo al codice del report
			$display = $dom->createElement('display');
			$display->setAttribute('value', $codice_visualizzabile_loinc);
			$display = $coding->appendChild($display);
		}
		
		
		//Creazione del nodo subject indicante il paziente soggetto del report
		$subject = $dom->createElement('subject');
		$subject = $DiagnosticReport->appendChild($subject);
		//Creazione del nodo reference per referenziare la risorsa relativa
		$reference = $dom->createElement('reference');
		$reference->setAttribute('value', "../fhir/Patient/".$idpaziente);
		$reference = $subject->appendChild($reference);
		
		
		//Creazione del nodo effectiveDateTime indicante la data di effettuazione del report
		$effectiveDateTime = $dom->createElement('effectiveDateTime');
		$effectiveDateTime->setAttribute('value', $datains);
		$effectiveDateTime = $DiagnosticReport->appendChild($effectiveDateTime);
		
		
		//Genero la data della versione del report diagnostico secondo lo standard ATOM ISO-8601
		$datetime = new DateTime($datains);
		//Creazione del nodo issued indicante la data della versione
		$issued = $dom->createElement('issued');
		$issued->setAttribute('value', $datetime->format(DateTime::ATOM));
		$issued = $DiagnosticReport->appendChild($issued);
		
		
		//Creazione del nodo performer indicante il care provider che ha eseguito il report
		$performer = $dom->createElement('performer');
		$performer = $DiagnosticReport->appendChild($performer);
		//Creazione del nodo reference per referenziare la risorsa relativa
		$reference = $dom->createElement('reference');
		$reference->setAttribute('value', "../fhir/Practitioner/".$idcareprovider);
		$reference = $performer->appendChild($reference);
		
		
		for($i=0;$i<$nindagini;$i++){
			//Creazione del nodo result indicante i risultati delle indagini diagnostiche
			$result = $dom->createElement('result');
			$result = $DiagnosticReport->appendChild($result);
			//Creazione del nodo reference per referenziare la risorsa relativa
			$reference = $dom->createElement('reference');
			$reference->setAttribute('value', "../fhir/Observation/".$idindagine[$i]);
			$reference = $result->appendChild($reference);
		}
		
		
		//Creazione del nodo conclusion con le conclusioni del report
		$conclusion = $dom->createElement('conclusion');
		$conclusion->setAttribute('value', $patologia);
		$conclusion = $DiagnosticReport->appendChild($conclusion);
		
		
		//Creazione del nodo codedDiagnosis con il codice per le conclusioni secondo la codifica SNOMED
		$codedDiagnosis = $dom->createElement('codedDiagnosis');
		$codedDiagnosis = $DiagnosticReport->appendChild($codedDiagnosis);
		//Creazione del nodo coding
		$coding = $dom->createElement('coding');
		$coding = $codedDiagnosis->appendChild($coding);
		//Creazione del nodo system per il value set SNOMED
		$system = $dom->createElement('system');
		$system->setAttribute('value', 'http://snomed.info/sct');
		$system = $coding->appendChild($system);
		//Creazione del nodo code con il valore del codice della conclusione
		$code = $dom->createElement('code');
		$code ->setAttribute('value', '122003');
		$code = $coding->appendChild($code);
		//Creazione del nodo display per la visualizzazione testuale del codice della conclusione
		$display = $dom->createElement('display');
		//Do il valore all' attributo del tag
		$display->setAttribute('value', 'Choroidal hemorrhage (disorder)');
		$display = $coding->appendChild($display);
		


		//Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
		$dom->preserveWhiteSpace = false;
		//Formattazione per l'output
		$dom->formatOutput = true;
		//Salvo il documento XML nella cartella rsources dando come nome, l'id del paziente
		//$dom->save("DiagnosticReport/".$diagnosi.".xml"); 
		
		return $dom->saveXML();
	}
}

?>