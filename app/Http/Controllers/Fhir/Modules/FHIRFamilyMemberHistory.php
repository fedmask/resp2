<?php

namespace App\Http\Controllers\Fhir\Modules;

use App\Exceptions\FHIR as FHIR;
use App\Http\Controllers\Fhir\Modules\FHIRResource;

/**
 * 
 * Al momento sospesa in quanto manca l'implementazione nel DB
 */

class FamilyMemberHistory extends FHIRResource {
    
    public function __construct() {}

    function deleteResource($id) {

        if (!AnamnesiFamiliare::where('id_anamnesi_familiare', $id)->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        

        # -----------------------------------------
        # ELIMINO I DATI DAL DATABASE

        AnamnesiFamiliare::find($id)->delete();
    }

    function updateResource($id, $xml) {
        $xml_values = simplexml_load_string($xml);
        $json = json_encode($xml_values);
        $array_data = json_decode($json, true);

        if (!AnamnesiFamiliare::where('id_anamnesi_familiare', $id)->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        $db_values = array(
            'idpaziente' => '',
            'dataAggiornamento' => '',
            'componente' => '',
            'sesso' => '',
            'anni' => '',
            'dataMorte' => '',
            'snomedId' => '',
            'note' => ''
        );

        // controllo che l'id passato come URL coincida con il campo id della
        // risorsa xml passata come input

        if ($id != $array_data['id']['@attributes']['value']) {
            throw new FHIR\MatchException('ID provided in url doesn\'t match the one in XML resource');
        }

        # -----------------------------------------
        # PARSO I DATI DAL DOCUMENTO XML

        // prelevo l'id del paziente
        if (preg_match("/^\.\.\/fhir\/Patient\/(.*?)$/i", $array_data['patient']['reference']['@attributes']['value'], $matches)) {
            $db_values['idpaziente'] = $matches[1];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid Patient id');
        }

        // prelevo la data di aggiornamento
        if (!empty($array_data['date']['@attributes']['value'])) {
            $dto = \DateTime::createFromFormat(\DateTime::ATOM, $array_data['date']['@attributes']['value']);
            $formattedDate = $dto->format('Y-m-d');

            $db_values['dataAggiornamento'] = $formattedDate;
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid date format');
        }

        // prelevo il nome del componente
        if (!empty($array_data['name']['@attributes']['value'])) {
            $db_values['componente'] = $array_data['name']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid component name');
        }

        // prelevo il genere del componente
        if (!empty($array_data['gender']['@attributes']['value'])) {
            $gender = $array_data['gender']['@attributes']['value'];

            switch($gender) {
                case 'female':
                    $db_values['sesso'] = 'F';
                    break;
                case 'male':
                    $db_values['sesso'] = 'M';
                    break;
                case 'other':
                    $db_values['sesso'] = 'O';
                    break;
            }
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid patient gender');
        }

        // prelevo gli anni
        if (!empty($array_data['ageString']['@attributes']['value'])) {
            $db_values['anni'] = $array_data['ageString']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid age');
        }

        // prelevo la data di morte
        if (!empty($array_data['deceasedString']['@attributes']['value'])) {
            $db_values['dataMorte'] = $array_data['deceasedString']['@attributes']['value'];
        } else if (!empty($array_data['deceasedBoolean']['@attributes']['value'])) {
            $db_values['dataMorte'] = 'NULL';
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid deceased date');
        }

        // parso il codice snomed da inserire nel database
        if (!empty($array_data['condition']['code']['coding']['code']['@attributes']['value'])) {
            $db_values['snomedId'] = $array_data['condition']['code']['coding']['code']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid snomed ct code');
        }

        // prelevo le note
        if (!empty($array_data['condition']['note']['text']['@attributes']['value'])) {
            $db_values['note'] = $array_data['condition']['note']['text']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid note for condition');
        }

        //print_r($db_values);

        # -----------------------------------------
        # AGGIORNO I DATI PARSATI NEL DATABASE

        $encrypted_notes = new Data($db_values['note']);
        $encrypted_notes = serializeData(encryptData($encrypted_notes));

        
        // query di inserimento che verra' eseguita
        $query_update = 'UPDATE anamnesifamiliare_nuova SET ' .
            'idpaziente = "' . $db_values['idpaziente'] . '", ' .
            'idcpp = NULL, ' .
            'dataAggiornamento = "' . $db_values['dataAggiornamento'] . '", ' .
            'componente = "' . $db_values['componente'] . '", ' .
            'sesso = "' . $db_values['sesso'] . '", ' .
            'anni = "' . $db_values['anni'] . '", ' .
            'dataMorte = ' . ($db_values['dataMorte'] == 'NULL' ? 'NULL' : '"' . $db_values['dataMorte'] . '"') . ', ' .
            'snomedId = ' . $db_values['snomedId'] . ', ' .
            'note = "' . $encrypted_notes . '" ' .
            'WHERE id = ' . $id;

        executeQuery($query_update);
    }

    function createResource($xml) {

        // converto il documento in formato json
        // per accedere facilmente alla struttura con un
        // array associativo php
        $xml_values = simplexml_load_string($xml);
        $json = json_encode($xml_values);
        $array_data = json_decode($json, true);

        //echo var_dump($array_data);

        $db_values = array(
            'idpaziente' => '',
            'dataAggiornamento' => '',
            'componente' => '',
            'sesso' => '',
            'anni' => '',
            'dataMorte' => '',
            'snomedId' => '',
            'note' => ''
        );

        # -----------------------------------------
        # PARSO I DATI DAL DOCUMENTO XML

        // controllo l'id della risorsa presa in input
        // se e' presente il campo allora ritorno un errore
        // poiche' nella create non deve mai essere specificato un id
        if (!empty($array_data['id']['@attributes']['value'])) {
            throw new IdFoundInCreateException('invalid id specified in CREATE');
        }

        // prelevo l'id del paziente
        if (preg_match("/^\.\.\/fhir\/Patient\/(.*?)$/i", $array_data['patient']['reference']['@attributes']['value'], $matches)) {
            $db_values['idpaziente'] = $matches[1];
        } else {
            throw new InvalidResourceFieldException('invalid Patient id');
        }

        // prelevo la data di aggiornamento
        if (!empty($array_data['date']['@attributes']['value'])) {
            $dto = \DateTime::createFromFormat(\DateTime::ATOM, $array_data['date']['@attributes']['value']);
            $formattedDate = $dto->format('Y-m-d');

            $db_values['dataAggiornamento'] = $formattedDate;
        } else {
            throw new InvalidResourceFieldException('invalid date format');
        }

        // prelevo il nome del componente
        if (!empty($array_data['name']['@attributes']['value'])) {
            $db_values['componente'] = $array_data['name']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid component name');
        }

        // prelevo il genere del componente
        if (!empty($array_data['gender']['@attributes']['value'])) {
            $gender = $array_data['gender']['@attributes']['value'];

            switch($gender) {
                case 'female':
                    $db_values['sesso'] = 'F';
                    break;
                case 'male':
                    $db_values['sesso'] = 'M';
                    break;
                case 'other':
                    $db_values['sesso'] = 'O';
                    break;
            }
        } else {
            throw new InvalidResourceFieldException('invalid patient gender');
        }

        // prelevo gli anni
        if (!empty($array_data['ageString']['@attributes']['value'])) {
            $db_values['anni'] = $array_data['ageString']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid age');
        }

        // prelevo la data di morte
        if (!empty($array_data['deceasedString']['@attributes']['value'])) {
            $db_values['dataMorte'] = $array_data['deceasedString']['@attributes']['value'];
        } else if (!empty($array_data['deceasedBoolean']['@attributes']['value'])) {
            $db_values['dataMorte'] = 'NULL';
        } else {
            throw new InvalidResourceFieldException('invalid deceased date');
        }

        // parso il codice snomed da inserire nel database
        if (!empty($array_data['condition']['code']['coding']['code']['@attributes']['value'])) {
            $db_values['snomedId'] = $array_data['condition']['code']['coding']['code']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid snomed ct code');
        }

        // prelevo le note
        if (!empty($array_data['condition']['note']['text']['@attributes']['value'])) {
            $db_values['note'] = $array_data['condition']['note']['text']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid note for condition');
        }

        //print_r($db_values);
        
        # -----------------------------------------
        # INSERISCO I DATI PARSATI NEL DATABASE

        $encrypted_notes = new Data($db_values['note']);
        $encrypted_notes = serializeData(encryptData($encrypted_notes));

        // query di inserimento che verra' eseguita
        $query_insert = 'INSERT INTO anamnesifamiliare_nuova (id, idpaziente, idcpp, dataAggiornamento, componente, sesso, anni, dataMorte, snomedId, note) VALUES (NULL, "'.$db_values['idpaziente'].'", NULL, "'.$db_values['dataAggiornamento'].'", "'.$db_values['componente'].'", "'.$db_values['sesso'].'", "'.$db_values['anni'].'", '.($db_values['dataMorte'] == 'NULL' ? 'NULL' : '"' . $db_values['dataMorte'] . '"').', '.$db_values['snomedId'].', "'.$encrypted_notes.'")';

        executeQuery($query_insert);

        // prelevo l'id del campo con i valori appena inseriti
        $value_id = getInfo('id', 'anamnesifamiliare_nuova',
            'idpaziente = "' . $db_values['idpaziente'] . '" AND ' .
            'dataAggiornamento = "' . $db_values['dataAggiornamento'] . '" AND ' .
            'componente = "' . $db_values['componente'] . '" AND ' .
            'sesso = "' . $db_values['sesso'] . '" AND ' .
            'anni = "' . $db_values['anni'] . '" AND ' .
            'dataMorte ' . ($db_values['dataMorte'] == 'NULL' ? ' IS NULL' : ' IS NOT NULL')  . ' AND ' .
            'snomedId = "' . $db_values['snomedId'] . '" AND ' .
            'note = "' . $encrypted_notes . '"'
        );

        return $value_id;
    }
    
    function getResource($id)
    {
        $id_anamnesi = $id;

        if (empty(getInfo('id', 'anamnesifamiliare_nuova', 'id = ' . $id))) {
            throw new IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        $db_values = array(
            "idpaziente" => "",
            "idcareprovider" => "",
            "dataaggiornamento" => "",
            "componente" => "",
            "sesso" => "",
            "anni" => "",
            "datamorte" => "",
            "idsnomed" => "",
            "annotazioni" => "",
        );

        // prelevo i campi della tabella anamnesi dal database
        // se l'id dell'anamnesi e' valido
        if ($id_anamnesi != null) {
            $db_values["idpaziente"] = getInfo('idpaziente', 'anamnesifamiliare_nuova', 'id = ' . $id_anamnesi);
            
            $db_values["idcareprovider"] = getInfo('idcpp', 'anamnesifamiliare_nuova', 'id = ' . $id_anamnesi);
            
            $db_values["dataaggiornamento"] = getInfo('dataAggiornamento', 'anamnesifamiliare_nuova', 'id = ' . $id_anamnesi);
            
            $db_values["componente"] = getInfo('componente', 'anamnesifamiliare_nuova', 'id = ' . $id_anamnesi);
            
            $db_values["sesso"] = getInfo('sesso', 'anamnesifamiliare_nuova', 'id = ' . $id_anamnesi);
            
            $db_values["anni"] = getInfo('anni', 'anamnesifamiliare_nuova', 'id = ' . $id_anamnesi);
            
            $db_values["datamorte"] = getInfo('dataMorte', 'anamnesifamiliare_nuova', 'id = ' . $id_anamnesi);

            $db_values["idsnomed"] = getInfo('snomedId', 'anamnesifamiliare_nuova', 'id = ' . $id_anamnesi);
            
            $db_values["annotazioni"] = getInfo('note', 'anamnesifamiliare_nuova', 'id = ' . $id_anamnesi);
        }

        // decritto l'unico campo delle annotazioni
        $db_values['annotazioni'] = decryptData(deserializeData($db_values['annotazioni']));

    /*
        foreach($db_values as $i => $value) {
            echo $i . " -> " . $value . "<br>";
        }
    */

        # -----------------------------------------
        # HEADER DEL DOCUMENTO XML

        // Creazione del documento xml con codifica del dom UTF-8
        $dom = new DOMDocument('1.0', 'utf-8');
        
        $node_fmh = $dom->createElement('FamilyMemberHistory');
        //Valorizzo il namespace della risorsa e del documento XML, in  questo caso la specifica FHIR
        $node_fmh->setAttribute('xmlns', 'http://hl7.org/fhir');
        //Corrello l'elemento con il nodo superiore
        $node_fmh = $dom->appendChild($node_fmh);

        //Creazione del nodo ID sempre presente nelle risorse FHIR
        $node_id = $dom->createElement('id');
        //Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
        $node_id->setAttribute('value', $id_anamnesi);
        $node_id = $node_fmh->appendChild($node_id);

        # -----------------------------------------
        # PARTE NARRATIVA

        //Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
        $node_narrative = $dom->createElement('text');
        //Corrello l'elemento con il nodo superiore
        $node_narrative = $node_fmh->appendChild($node_narrative);

        //Creazione del nodo status che indica lo stato della parte narrativa
        $node_status = $dom->createElement('status');
        //Il valore del nodo status è sempre generated, la parte narrativa è generato dal sistema
        $node_status->setAttribute('value', 'generated');
        $node_status = $node_narrative->appendChild($node_status);

        //Creazione del div che conterrà la tabella con i valori visualizzabili nella parte narrativa
        $node_div = $dom->createElement('div');
        //Link al value set della parte narrativa, cioè la codifica XHTML
        $node_div->setAttribute('xmlns',"http://www.w3.org/1999/xhtml");
        $node_div = $node_narrative->appendChild($node_div);

        //Creazione della tabella che conterrà i valori
        $node_table = $dom->createElement('table');
        $node_table->setAttribute('border',"2");
        $node_table = $node_div->appendChild($node_table);

        //Creazione del nodo tbody
        $node_tbody = $dom->createElement('tbody');
        $node_tbody = $node_table->appendChild($node_tbody);

        //Creazione di una riga
        $node_tr = $dom->createElement('tr');
        $node_tr = $node_tbody->appendChild($node_tr);

        // Creazione delle tabelle con i valori del database

        $node_td = $dom->createElement('td',"Member");
        $node_td = $node_tr->appendChild($node_td);

        $node_td = $dom->createElement('td', $db_values["componente"]);
        $node_td = $node_tr->appendChild($node_td);

        //Creazione di una riga
        $node_tr = $dom->createElement('tr');
        $node_tr =$node_tbody->appendChild($node_tr);

        $node_td = $dom->createElement('td',"Sex");
        $node_td = $node_tr->appendChild($node_td);

        $node_td = $dom->createElement('td', $db_values["sesso"]);
        $node_td = $node_tr->appendChild($node_td);

        //Creazione di una riga
        $node_tr = $dom->createElement('tr');
        $node_tr =$node_tbody->appendChild($node_tr);

        $node_td = $dom->createElement('td',"Age");
        $node_td = $node_tr->appendChild($node_td);

        $node_td = $dom->createElement('td', $db_values["anni"]);
        $node_td = $node_tr->appendChild($node_td);

        //Creazione di una riga
        $node_tr = $dom->createElement('tr');
        $node_tr =$node_tbody->appendChild($node_tr);

        $node_td = $dom->createElement('td',"Annotation");
        $node_td = $node_tr->appendChild($node_td);

        $node_td = $dom->createElement('td', $db_values["annotazioni"]);
        $node_td = $node_tr->appendChild($node_td);

        # -----------------------------------------
        # PARTE STRUTTURA DATI

        $node_identifier = $dom->createElement('identifier');
        $node_identifier = $node_fmh->appendChild($node_identifier);

        //Creazione del nodo use con valore fisso ad usual
        $node_use = $dom->createElement('use');
        $node_use->setAttribute('value', 'usual');
        $node_use = $node_identifier->appendChild($node_use);

        //Creazione del nodo system che identifica il namespace degli URI per identificare la risorsa
        $node_system = $dom->createElement('system');
        $node_system->setAttribute('value', 'urn:ietf:rfc:3986'); //RFC
        $node_system = $node_identifier->appendChild($node_system);

        $node_value = $dom->createElement('value');
        //Do il valore all' URI della risorsa
        $node_value->setAttribute('value', "../fhir/FamilyMemberHistory/".$id_anamnesi);
        $node_value = $node_identifier->appendChild($node_value);

        //Creazione del nodo patient indicante il paziente soggetto del report
        $node_patient = $dom->createElement('patient');
        $node_patient = $node_fmh->appendChild($node_patient);
        
        //Creazione del nodo reference per referenziare la risorsa relativa
        $node_reference = $dom->createElement('reference');
        $node_reference->setAttribute('value', "../fhir/Patient/".$db_values["idpaziente"]);
        $node_reference = $node_patient->appendChild($node_reference);

        // Creazione del nodo date usando lo standard ATOM ISO-8601
        $date_time = new DateTime($db_values["dataaggiornamento"]);
        $node_updatedate = $dom->createElement('date');
        $node_updatedate->setAttribute('value', $date_time->format(DateTime::ATOM));
        $node_updatedate = $node_fmh->appendChild($node_updatedate);

        //Creazione del nodo statusn settato sempre a completed in quanto il report è completo
        $node_status = $dom->createElement('status');
        $node_status->setAttribute('value', 'completed');
        $node_status = $node_fmh->appendChild($node_status);

        // Creazione del nodo name per il componente familiare
        $node_name = $dom->createElement('name');
        $node_name->setAttribute('value', $db_values["componente"]);
        $node_name = $node_fmh->appendChild($node_name);

        // creazione del nodo relationship con valore del codice
        // della relazione fisso a FAMMEMB poiche' nel sistema
        // non viene specificato per le anamnesi il tipo di relazione

        $node_relationship = $dom->createElement('relationship');
        $node_relationship = $node_fmh->appendChild($node_relationship);

        $node_coding = $dom->createElement('coding');
        $node_coding = $node_relationship->appendChild($node_coding);

        $node_system = $dom->createElement('system');
        $node_system->setAttribute('value', 'http://hl7.org/fhir/v3/RoleCode');
        $node_system = $node_coding->appendChild($node_system);

        $node_code = $dom->createElement('code');
        $node_code->setAttribute('value', 'FAMMEMB');
        $node_code = $node_coding->appendChild($node_code);


        // Creazione del nodo che indica il genere della persona
        // codificanto il tipo presente nel database
        $value_gender = "";
        switch ($db_values["sesso"]) {
            case 'M':
                $value_gender = "male";
                break;
            case 'F':
                $value_gender = "female";
                break;
            default:
                $value_gender = "other";
        }
        $node_gender = $dom->createElement('gender');
        $node_gender->setAttribute('value', $value_gender);
        $node_gender = $node_fmh->appendChild($node_gender);


        // creazione del nodo borndate
        $value_borndate = "";
        
        if (strlen($db_values["anni"]) > 0) {
            $date_time = DateTime::createFromFormat("Y-m-d", $db_values["dataaggiornamento"]);
            $value_borndate = $date_time->format("Y") - $db_values["anni"];
            $value_borndate .= "-01-01";
        }

        $node_borndate = $dom->createElement('bornString');
        $node_borndate->setAttribute('value', $value_borndate);
        $node_borndate = $node_fmh->appendChild($node_borndate);

        // creazione del nodo degli anni
        $node_age = $dom->createElement('ageString');
        $node_age->setAttribute('value', $db_values["anni"]);
        $node_age = $node_fmh->appendChild($node_age);

        // creazion del nodo che rappresenta la data di morte
        $deceased = (strlen($db_values["datamorte"]) != 0);

        if ($deceased) {
            $node_deceased = $dom->createElement('deceasedString');
            $node_deceased->setAttribute('value', $db_values["datamorte"]);
        } else {
            $node_deceased = $dom->createElement('deceasedBoolean');
            $node_deceased->setAttribute('value', 'false');
        }

        $node_deceased = $node_fmh->appendChild($node_deceased);

        // nodo condition
        $node_condition = $dom->createElement('condition');
        $node_condition = $node_fmh->appendChild($node_condition);

        $node_code = $dom->createElement('code');
        $node_code = $node_condition->appendChild($node_code);

        $node_coding = $dom->createElement('coding');
        $node_coding = $node_code->appendChild($node_coding);

        $node_system = $dom->createElement('system');
        $node_system->setAttribute('value', 'http://snomed.info/sct');
        $node_system = $node_coding->appendChild($node_system);

        // poiche' il registro non e' ancora predisposto con una
        // tabella contenente i codici SNOMED CT, riempio questo
        // campo con un valore di esempio. Se pero' il codice dovesse
        // essere presente nell'istanza del database allora lo mostro
        // correttamente come risorsa

        // codice snomed di esempio: Anxiety disorder of childhood OR adolescence (disorder)
        $snomed_ct_id = '109006';
        if (!empty($db_values['idsnomed'])) {
            $snomed_ct_id = $db_values['idsnomed'];
        }

        $node_code = $dom->createElement('code');
        $node_code->setAttribute('value', $snomed_ct_id);
        $node_code = $node_coding->appendChild($node_code);

        // creazione del nodo note
        $node_note = $dom->createElement('note');
        $node_note = $node_condition->appendChild($node_note);

        // creazione nodo autore
        $node_author = $dom->createElement('authorReference');
        $node_author = $node_note->appendChild($node_author);

        $node_reference = $dom->createElement('reference');
        $made_by_patient = (strlen($db_values["idcareprovider"]) == 0);

        if ($made_by_patient) {
            $node_reference->setAttribute('value', "../fhir/Patient/".$db_values["idpaziente"]);
        } else {
            // prelevo l'id del care provider
            $value_idcareprovider = getInfo('id', 'careproviderpersona', 'idutente = ' . $db_values["idcareprovider"]);
            $node_reference->setAttribute('value', "../fhir/Practitioner/" . $value_idcareprovider);
        }

        $node_reference = $node_author->appendChild($node_reference);

        // creazione del noto text

        $node_text = $dom->createElement('text');
        $node_text->setAttribute('value', $db_values["annotazioni"]);
        $node_text = $node_note->appendChild($node_text);


        # -----------------------------------------
        # OPERAZIONI AUSILIARI SUL DOCUMENTO XML

        //Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
        $dom->preserveWhiteSpace = false;
        //Formattazione per l'output
        $dom->formatOutput = true;
        //Salvo il documento XML nella cartella resources dando come nome, l'id preso in input
        //$dom->save("FamilyMemberHistory/".$id_anamnesi.".xml"); 

        return $dom->saveXML();
    }
}

?>