<?php
namespace App\Http\Controllers\Fhir\Modules;

use App\Exceptions\FHIR as FHIR;
use App\Http\Controllers\Fhir\Modules\FHIRResource;
use App\Models\InvestigationCenter\CentriIndagini;
use App\Models\InvestigationCenter\Indagini;

class FHIROrganization extends FHIRResource {
    
    public function __construct() {}

    function deleteResource($id) {
        
        if (!CentriIndagini::where('id_centro', $id)->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        # ELIMINO I DATI DAL DATABASE
        
        CentriIndagini::find($id)->delete();

        // effettuo un nuovo controllo per verificare se la risorsa e' stata
        // effettivamente eliminata

        if (!CentriIndagini::where('id_centro_indagine', $id)->exists()) {
            throw new DeleteRequestRefusedException("can't delete resources with id provided");
        }

        /** @TODO: Verificare nel vecchio DB questa sezione **/
        
      //  $query_delete = 'DELETE FROM telefonocentriindagini WHERE idCentroIndagini = "' . $id . '"';
      //  executeQuery($query_delete);

        // effettuo un nuovo controllo per verificare se la risorsa e' stata
        // effettivamente eliminata

//        if (!empty(getInfo('id', 'telefonocentriindagini', 'id = ' . $id))) {
//            throw new DeleteRequestRefusedException("can't delete resources with id provided");
//        }
    }

    function updateResource($id, $xml) {
        $xml_values = simplexml_load_string($xml);
        $json = json_encode($xml_values);
        $array_data = json_decode($json, true);

        if (!CentriIndagini::where('id_centro', $id)->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        //echo var_dump($array_data);

        $db_values = array(
            'idcpp' => '',
            'nomeStudio' => '',
            'via' => '',
            'citta' => '',
            'tipoCentro' => '',
            'mail' => '',
            'telefono' => array(),
        );

        # -----------------------------------------
        # PARSO I DATI DAL DOCUMENTO XML

        // controllo che l'id passato come URL coincida con il campo id della
        // risorsa xml passata come input
        if ($id != $array_data['id']['@attributes']['value']) {
            throw new MatchException('ID provided in url doesn\'t match the one in XML resource');
        }

        if (!array_key_exists('extension', $array_data))
            throw new InvalidResourceFieldException('an extension is missing');

        // prelevo i campi delle estensioni
        foreach($array_data['extension'] as $extension_element) {
            switch ($extension_element['@attributes']['url']) {
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/practitioner-id.xml':
                    $db_values['idcpp'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/organization-type.xml';
                    $db_values['tipoCentro'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                default:
                    throw new InvalidResourceFieldException('an extension is missing');
            }
        }

        // prelevo il nome
        if (!empty($array_data['name']['@attributes']['value'])) {
            $db_values['nomeStudio'] = $array_data['name']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid name');
        }

        // prelevo la via
        if (!empty($array_data['address']['line']['@attributes']['value'])) {
            $db_values['via'] = $array_data['address']['line']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid age');
        }

        // prelevo la citta'
        if (!empty($array_data['address']['city']['@attributes']['value'])) {
            $db_values['citta'] = $array_data['address']['city']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid age');
        }

        // prelevo i vari dati del campo telecom come email e numeri di telefono

        foreach($array_data['telecom'] as $contact) {
            if ($contact['system']['@attributes']['value'] == 'email') {
                $db_values['mail'] = $contact['value']['@attributes']['value'];
            } else {
                array_push($db_values['telefono'], $contact['value']['@attributes']['value']);
            }
        }

        //print_r($db_values);

        # -----------------------------------------
        # AGGIORNO I DATI PARSATI NEL DATABASE

        $centro_indagine = CentriIndagini::find($id);
        
        $centro_indagine->centro_nome = $db_values['nomeStudio'];
        $centro_indagine->centro_indirizzo = $db_values['via'];
        $centro_indagine->id_cpp_persona = $db_values['idcpp'];
        
        $centro_tipologia = CentriTipologie::where('tipologia_nome', $db_values['tipoCentro'])->first();
        
        $centro_indagine->id_tipologia = $centro_tipologia->id_centro_tipologia;
        
        $centro_citta     = Comuni::where('comune_nominativo', $db_values['citta'])->first();
        $centro_indagine->id_citta = $centro_citta->id_comune;
        
        /** TODO: Verificare i contatti email, telefono ecc..**/
        
        $centro_indagine->save();
    
        /*
        // cancello i numeri di telefono precedenti
        $query_delete = 'DELETE FROM telefonocentriindagini WHERE idCentroIndagini = "' . $id . '"';
        executeQuery($query_delete);

        // aggiungo i nuovi numeri di telefono
        foreach($db_values['telefono'] as $num) {
            $query_insert = 'INSERT INTO telefonocentriindagini (telefono, idCentroIndagini) values ("' . $num . '", "' . $id . '")';

            executeQuery($query_insert);
        }
        */
    }

    function createResource($xml) {
        $xml_values = simplexml_load_string($xml);
        $json = json_encode($xml_values);
        $array_data = json_decode($json, true);

        //echo var_dump($array_data);

        $db_values = array(
            'idcpp' => '',
            'nomeStudio' => '',
            'via' => '',
            'citta' => '',
            'tipoCentro' => '',
            'mail' => '',
            'telefono' => array(),
        );

        #-----------------------------------------
        # PARSO I DATI DAL DOCUMENTO XML

        // controllo l'id della risorsa presa in input
        // se e' presente il campo allora ritorno un errore
        // poiche' nella create non deve mai essere specificato un id
        if (!empty($array_data['id']['@attributes']['value'])) {
            throw new IdFoundInCreateException('invalid id specified in CREATE');
        }

        if (!array_key_exists('extension', $array_data))
            throw new InvalidResourceFieldException('an extension is missing');

        // prelevo i campi delle estensioni
        foreach($array_data['extension'] as $extension_element) {
            switch ($extension_element['@attributes']['url']) {
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/practitioner-id.xml':
                    $db_values['idcpp'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/organization-type.xml';
                    $db_values['tipoCentro'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                default:
                    throw new InvalidResourceFieldException('an extension is missing');
            }
        }

        // prelevo il nome
        if (!empty($array_data['name']['@attributes']['value'])) {
            $db_values['nomeStudio'] = $array_data['name']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid name');
        }

        // prelevo la via
        if (!empty($array_data['address']['line']['@attributes']['value'])) {
            $db_values['via'] = $array_data['address']['line']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid age');
        }

        // prelevo la citta'
        if (!empty($array_data['address']['city']['@attributes']['value'])) {
            $db_values['citta'] = $array_data['address']['city']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid age');
        }

        // prelevo i vari dati del campo telecom come email e numeri di telefono

        foreach($array_data['telecom'] as $contact) {
            if ($contact['system']['@attributes']['value'] == 'email') {
                $db_values['mail'] = $contact['value']['@attributes']['value'];
            } else {
                array_push($db_values['telefono'], $contact['value']['@attributes']['value']);
            }
        }

        //print_r($db_values);

        # -----------------------------------------
        # INSERISCO I DATI PARSATI NEL DATABASE

        $centro_indagine = new CentriIndagini();
        
        $centro_indagine->centro_nome = $db_values['nomeStudio'];
        $centro_indagine->centro_indirizzo = $db_values['via'];
        $centro_indagine->id_cpp_persona = $db_values['idcpp'];
        
        $centro_tipologia = CentriTipologie::where('tipologia_nome', $db_values['tipoCentro'])->first();
        
        $centro_indagine->id_tipologia = $centro_tipologia->id_centro_tipologia;
        
        $centro_citta     = Comuni::where('comune_nominativo', $db_values['citta'])->first();
        $centro_indagine->id_citta = $centro_citta->id_comune;
        
      
        $centro_indagine->save();

        
        // prelevo l'id del campo con i valori appena inseriti
        $value_id = $centro_indagine->id_centro;
        
        // inserisco anche nella tabella telefonocentriindagini
        /*
        foreach($db_values['telefono'] as $num) {
            $query_insert = 'INSERT INTO telefonocentriindagini (telefono, idCentroIndagini) values ("' . $num . '", "' . $value_id . '")';

            executeQuery($query_insert);

            if (empty(getInfo('telefono', 'telefonocentriindagini', 'idCentroIndagini = ' . $value_id))) {
                throw new IdNotFoundInDatabaseException('can\'t insert telephone into database due to a problem');
            }
        }
        
        */

        return $value_id;
    }

    function getResource($id) {
        $id_centro = $id;

        if (!CentriIndagini::where('id_centro', $id)->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        $db_values = array(
            'idcpp' => '',
            'nomeStudio' => '',
            'via' => '',
            'citta' => '',
            'tipoCentro' => '',
            'mail' => '',
            'telefono' => array(),

            'nome_cpp' => '',
            'cognome_cpp' => '',
        );

        $centro_indagine = CentriIndagini::find($id)->first();
        
        // prelevo i campi della tabella centriindagini e telefonocentriindagini se l'id e' valido
        $db_values['idcpp'] = $centro_indagine->id_cpp_persona; // getInfo('idcpp', 'centriindagini', 'id = ' . $id_centro);
        $db_values['nomeStudio'] = $centro_indagine->centro_nome; //getInfo('nomeStudio', 'centriindagini', 'id = ' . $id_centro);
        $db_values['via'] = $centro_indagine->centro_indirizzo; //getInfo('via', 'centriindagini', 'id = ' . $id_centro);
        $db_values['citta'] = $centro_indagine->id_citta; //getInfo('citta', 'centriindagini', 'id = ' . $id_centro);
        $db_values['tipoCentro'] = $centro_indagine->id_tipologia; //getInfo('tipoCentro', 'centriindagini', 'id = ' . $id_centro);
        $db_values['mail'] = ""; //getInfo('mail', 'centriindagini', 'id = ' . $id_centro);

        /*
        // prelevo i numeri di telefono di un centro
        $db_values['telefono'] = getArray('telefono', 'telefonocentriindagini', 'idCentroIndagini = ' . $id_centro);
        */
        
        // se esiste il careprovider nel database allora prelevo il nome ed il cognome
        if (!CppPersona::where('id_persona', $db_values['idcpp'])->exists()) {
            $db_values['cognome_cpp'] = CppPersona::find($db_values['idcpp'])->first()->persona_cognome;//   getInfo('cognome', 'careproviderpersona', 'id = ' . $db_values['idcpp']);
            $db_values['nome_cpp'] = CppPersona::find($db_values['idcpp'])->first()->persona_nome; //getInfo('nome', 'careproviderpersona', 'id = ' . $db_values['idcpp']);
        }
        

        # -----------------------------------------
        # HEADER DEL DOCUMENTO XML

        // Creazione del documento xml con codifica del dom UTF-8
        $dom = new \DOMDocument('1.0', 'utf-8');

        $node_org = $dom->createElement('Organization');
        //Valorizzo il namespace della risorsa e del documento XML, in  questo caso la specifica FHIR
        $node_org->setAttribute('xmlns', 'http://hl7.org/fhir');
        //Corrello l'elemento con il nodo superiore
        $node_org = $dom->appendChild($node_org);

        //Creazione del nodo ID sempre presente nelle risorse FHIR
        $node_id = $dom->createElement('id');
        //Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
        $node_id->setAttribute('value', $id_centro);
        $node_id = $node_org->appendChild($node_id);

        # -----------------------------------------
        # PARTE NARRATIVA

        $node_narrative = $dom->createElement('text');
        $node_narrative = $node_org->appendChild($node_narrative);

        $node_status = $dom->createElement('status');
        $node_status->setAttribute('value', 'generated');
        $node_status = $node_narrative->appendChild($node_status);

        $node_div = $dom->createElement('div');
        $node_div->setAttribute('xmlns',"http://www.w3.org/1999/xhtml");
        $node_div = $node_narrative->appendChild($node_div);

        $node_table = $dom->createElement('table');
        $node_table->setAttribute('border',"2");
        $node_table = $node_div->appendChild($node_table);

        $node_tbody = $dom->createElement('tbody');
        $node_tbody = $node_table->appendChild($node_tbody);

        // creazione riga

        $node_tr = $dom->createElement('tr');
        $node_tr = $node_tbody->appendChild($node_tr);

        $node_td = $dom->createElement('td', 'Nome studio');
        $node_td = $node_tr->appendChild($node_td);

        $node_td = $dom->createElement('td', $db_values['nomeStudio']);
        $node_td = $node_tr->appendChild($node_td);

        // creazione riga

        if (!empty($db_values['nome_cpp'])) {
            $node_tr = $dom->createElement('tr');
            $node_tr = $node_tbody->appendChild($node_tr);

            $node_td = $dom->createElement('td', 'Care provider');
            $node_td = $node_tr->appendChild($node_td);

            $node_td = $dom->createElement('td', 'Dott. ' . $db_values['cognome_cpp'] . ' ' . $db_values['nome_cpp']);
            $node_td = $node_tr->appendChild($node_td);
        }

        // creazione riga

        $node_tr = $dom->createElement('tr');
        $node_tr = $node_tbody->appendChild($node_tr);

        $node_td = $dom->createElement('td', 'Via');
        $node_td = $node_tr->appendChild($node_td);

        $node_td = $dom->createElement('td', $db_values['via']);
        $node_td = $node_tr->appendChild($node_td);

        // creazione riga

        $node_tr = $dom->createElement('tr');
        $node_tr = $node_tbody->appendChild($node_tr);

        $node_td = $dom->createElement('td', 'Citta\'');
        $node_td = $node_tr->appendChild($node_td);

        $node_td = $dom->createElement('td', $db_values['citta']);
        $node_td = $node_tr->appendChild($node_td);

        // creazione riga

        $node_tr = $dom->createElement('tr');
        $node_tr = $node_tbody->appendChild($node_tr);

        $node_td = $dom->createElement('td', 'Tipo centro');
        $node_td = $node_tr->appendChild($node_td);

        $node_td = $dom->createElement('td', $db_values['tipoCentro']);
        $node_td = $node_tr->appendChild($node_td);

        // creazione riga

        $node_tr = $dom->createElement('tr');
        $node_tr = $node_tbody->appendChild($node_tr);

        $node_td = $dom->createElement('td', 'Email');
        $node_td = $node_tr->appendChild($node_td);

        $node_td = $dom->createElement('td', $db_values['mail']);
        $node_td = $node_tr->appendChild($node_td);

        // creazione riga

        $node_tr = $dom->createElement('tr');
        $node_tr = $node_tbody->appendChild($node_tr);

        $node_td = $dom->createElement('td', 'Telefono');
        $node_td = $node_tr->appendChild($node_td);

        $numeri = '';

        foreach($db_values['telefono'] as $nums) {
            $numeri .= $nums . ' - ';
        }

        $node_td = $dom->createElement('td', $numeri);
        $node_td = $node_tr->appendChild($node_td);

        # -----------------------------------------
        # PARTE ESTENSIONE

        // creazione del nodo dell'extension del comune
        $node_extension_icpp = $dom->createElement('extension');
        $node_extension_icpp->setAttribute('url', 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/practitioner-id.xml');
        $node_extension_icpp = $node_org->appendChild($node_extension_icpp);

        $node_valueString = $dom->createElement('valueString');
        $node_valueString->setAttribute('value', $db_values['idcpp']);
        $node_valueString = $node_extension_icpp->appendChild($node_valueString);

        // creazione del nodo dell'extension del comune
        $node_extension_orgtype = $dom->createElement('extension');
        $node_extension_orgtype->setAttribute('url', 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/organization-type.xml');
        $node_extension_orgtype = $node_org->appendChild($node_extension_orgtype);

        $node_valueString = $dom->createElement('valueString');
        $node_valueString->setAttribute('value', $db_values['tipoCentro']);
        $node_valueString = $node_extension_orgtype->appendChild($node_valueString);

        # -----------------------------------------
        # PARTE STRUTTURA DATI

        // Organization.identifier

        $node_identifier = $dom->createElement('identifier');
        $node_identifier = $node_org->appendChild($node_identifier);

        $node_use = $dom->createElement('use');
        $node_use->setAttribute('value', 'usual');
        $node_use = $node_identifier->appendChild($node_use);

        $node_system = $dom->createElement('system');
        $node_system->setAttribute('value', 'urn:ietf:rfc:3986'); //RFC
        $node_system = $node_identifier->appendChild($node_system);

        $node_value = $dom->createElement('value');
        $node_value->setAttribute('value', "../fhir/Organization/" . $id_centro);
        $node_value = $node_identifier->appendChild($node_value);

        // Organization.active

        $node_active = $dom->createElement('active');
        $node_active->setAttribute('value', 'true');
        $node_active = $node_org->appendChild($node_active);

        // Organization.type

        $node_type = $dom->createElement('type');
        $node_type = $node_org->appendChild($node_type);

        $node_coding = $dom->createElement('coding');
        $node_coding = $node_type->appendChild($node_coding);

        $node_system = $dom->createElement('system');
        $node_system->setAttribute('value', 'http://hl7.org/fhir/organization-type');
        $node_system = $node_coding->appendChild($node_system);

        // il codice 'prov' sta per Healthcare Provider
        $node_code = $dom->createElement('code');
        $node_code->setAttribute('value', 'prov');
        $node_code = $node_coding->appendChild($node_code);

        // Organization.name

        $node_name = $dom->createElement('name');
        $node_name->setAttribute('value', $db_values['nomeStudio']);
        $node_name = $node_org->appendChild($node_name);

        // Organization.telecom

        /**
        foreach ($db_values['telefono'] as $index => $number) {
            $node_telecom = $dom->createElement('telecom');
            $node_telecom = $node_org->appendChild($node_telecom);

            $node_system = $dom->createElement('system');
            $node_system->setAttribute('value', 'phone');
            $node_system = $node_telecom->appendChild($node_system);

            $node_value = $dom->createElement('value');
            $node_value->setAttribute('value', $number);
            $node_value = $node_telecom->appendChild($node_value);

            $node_use = $dom->createElement('use');
            $node_use->setAttribute('value', ($number[0] == '3' ? 'mobile' : 'work'));
            $node_use = $node_telecom->appendChild($node_use);

            $node_rank = $dom->createElement('rank');
            $node_rank->setAttribute('value', ($index + 1));
            $node_rank = $node_telecom->appendChild($node_rank);
        }
        */

        // campo telecom che indica l'indirizzo email
        $node_telecom = $dom->createElement('telecom');
        $node_telecom = $node_org->appendChild($node_telecom);

        $node_system = $dom->createElement('system');
        $node_system->setAttribute('value', 'email');
        $node_system = $node_telecom->appendChild($node_system);

        $node_value = $dom->createElement('value');
        $node_value->setAttribute('value', $db_values['mail']);
        $node_value = $node_telecom->appendChild($node_value);

        $node_use = $dom->createElement('use');
        $node_use->setAttribute('value', 'work');
        $node_use = $node_telecom->appendChild($node_use);

        // Organization.address

        $node_address = $dom->createElement('address');
        $node_address = $node_org->appendChild($node_address);

        $node_line = $dom->createElement('line');
        $node_line->setAttribute('value', $db_values['via']);
        $node_line = $node_address->appendChild($node_line);

        $node_city = $dom->createElement('city');
        $node_city->setAttribute('value', $db_values['citta']);
        $node_city = $node_address->appendChild($node_city);

        $node_country = $dom->createElement('country');
        $node_country->setAttribute('value', 'IT');
        $node_country = $node_address->appendChild($node_country);

        // Organization.contact

        $node_contact = $dom->createElement('contact');
        $node_contact = $node_org->appendChild($node_contact);

        $node_name = $dom->createElement('name');
        $node_name = $node_contact->appendChild($node_name);

        $node_family = $dom->createElement('family');
        $node_family->setAttribute('value', $db_values['cognome_cpp']);
        $node_family = $node_name->appendChild($node_family);

        $node_given = $dom->createElement('given');
        $node_given->setAttribute('value', $db_values['nome_cpp']);
        $node_given = $node_name->appendChild($node_given);

        $node_prefix = $dom->createElement('prefix');
        $node_prefix->setAttribute('value', 'Dott.');
        $node_prefix = $node_name->appendChild($node_prefix);

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