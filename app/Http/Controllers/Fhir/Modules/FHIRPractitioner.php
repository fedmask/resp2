<?php

namespace App\Http\Controllers\Fhir\Modules;

use App\Http\Controllers\Fhir\Modules\FHIRResource as FHIR;
use App\Exceptions\FHIR as FHIR;
use App\Models\CareProvider\CppPersona;
use Illuminate\Http\Request;
use App;
use Redirect;

class FHIRPractitioner extends FHIRResource {
    
    public function __construct() {
    //    $a = new ResourceExceptions();
    }

    function deleteResource($id) {
        
        if (!CppPersona::where('id_persona', $id)->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        # ELIMINO I DATI DAL DATABASE

        CppPersona::find($id)->delete();
    }

    function updateResource($id, $xml) {
        $xml_values = simplexml_load_string($xml);
        $json = json_encode($xml_values);
        $array_data = json_decode($json, true);

        if (!CppPersona::where('id_persona', $id)->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        $db_values = array(
            'nome' => '',
            'cognome' => '',
            'telefono' => '',
            'fax' => '000000', // default fax
            'comune' => '',    // preleviamo il comune e l'id utente
            'idutente' => '',  // mediante delle estensioni alla risorsa practitioner
            'active' => ''
        );

        # -----------------------------------------
        # PARSO I DATI DAL DOCUMENTO XML

        // controllo che l'id passato come URL coincida con il campo id della
        // risorsa xml passata come input

        if ($id != $array_data['id']['@attributes']['value']) {
            throw new FHIR\MatchException('ID provided in url doesn\'t match the one in XML resource');
        }

        // prelevo il nome del care provider
        if (!empty($array_data['name']['family']['@attributes']['value']) &&
            !empty($array_data['name']['given']['@attributes']['value'])) {
            $db_values['cognome'] = $array_data['name']['family']['@attributes']['value'];
            $db_values['nome'] = $array_data['name']['given']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid care provider name and surname');
        }

        // prelevo i campi delle estensioni
        foreach($array_data['extension'] as $extension_element) {
            switch ($extension_element['@attributes']['url']) {
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/practitioner-comune.xml':
                    $db_values['comune'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/user-id.xml';
                    $db_values['idutente'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                default:
                    throw new FHIR\InvalidResourceFieldException('an extension is missing');
            }
        }
        
        // prelevo il numero di telefono
        if (!empty($array_data['telecom']['value']['@attributes']['value'])) {
            $db_values['telefono'] = $array_data['telecom']['value']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid phone number');
        }

        // prelevo il campo active
        if (!empty($array_data['active']['@attributes']['value'])) {
            $active_value = $array_data['active']['@attributes']['value'];

            $db_values['active'] = ($active_value == 'true') ? '1' : 'NULL';
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid active field');
        }

        # AGGIORNO I DATI PARSATI NEL DATABASE

        $comune_nascita = Comuni::where('comune_nominativo', $db_values['comune'])->first();
        
        $careProviderPersona = CppPersona::find($id);
        
        $careProviderPersona->id_utente = $db_values['idutente'];
        $careProviderPersona->id_comune = $comune_nascita->id_comune;
        $careProviderPersona->persona_nome = $db_values['nome'];
        $careProviderPersona->persona_cognome = $db_values['cognome'];
        $careProviderPersona->persona_telefono = $db_values['telefono'];
        $careProviderPersona->persona_fax = $db_values['fax'];
        $careProviderPersona->persona_attivo = $db_values['active'];
        
        $careProviderPersona->save();

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
            'nome' => '',
            'cognome' => '',
            'telefono' => '',
            'fax' => '000000', // default fax
            'comune' => '',    // preleviamo il comune e l'id utente
            'idutente' => '',  // mediante delle estensioni alla risorsa practitioner
            'active' => ''
        );

        # -----------------------------------------
        # PARSO I DATI DAL DOCUMENTO XML

        if (!empty($array_data['id']['@attributes']['value'])) {
            throw new FHIR\IdFoundInCreateException('invalid id specified in CREATE');
        }

        // prelevo il nome del care provider
        if (!empty($array_data['name']['family']['@attributes']['value']) &&
            !empty($array_data['name']['given']['@attributes']['value'])) {
            $db_values['cognome'] = $array_data['name']['family']['@attributes']['value'];
            $db_values['nome'] = $array_data['name']['given']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid care provider name and surname');
        }

        // prelevo i campi delle estensioni
        foreach($array_data['extension'] as $extension_element) {
            switch ($extension_element['@attributes']['url']) {
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/practitioner-comune.xml':
                    $db_values['comune'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/user-id.xml';
                    $db_values['idutente'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                default:
                    throw new FHIR\InvalidResourceFieldException('an extension is missing');
            }
        }
        
        // prelevo il numero di telefono
        if (!empty($array_data['telecom']['value']['@attributes']['value'])) {
            $db_values['telefono'] = $array_data['telecom']['value']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid phone number');
        }

        // prelevo il campo active
        if (!empty($array_data['active']['@attributes']['value'])) {
            $active_value = $array_data['active']['@attributes']['value'];

            $db_values['active'] = ($active_value == 'true') ? '1' : 'NULL';
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid active field');
        }

        # -----------------------------------------
        # INSERISCO I DATI PARSATI NEL DATABASE

        $comune_nascita = Comuni::where('comune_nominativo', $db_values['comune'])->first();
        
        $careProviderPersona = new CppPersona();
        
        $careProviderPersona->id_utente = $db_values['idutente'];
        $careProviderPersona->id_comune = $comune_nascita->id_comune;
        $careProviderPersona->persona_nome = $db_values['nome'];
        $careProviderPersona->persona_cognome = $db_values['cognome'];
        $careProviderPersona->persona_telefono = $db_values['telefono'];
        $careProviderPersona->persona_fax = $db_values['fax'];
        $careProviderPersona->persona_attivo = $db_values['active'];
        
        $careProviderPersona->save();
        
        return CppPersona::find('id_utente', $db_values['idutente'])->first()->id_persona;
    }

    function getResource($id)
    {
        if (!CppPersona::where('id_persona', $id)->exists()) {
            App::abort(403, "resource with the id provided doesn't exist in database");
        }

        //dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
        $careproviders = "";
        
        //dichiaro le variabili in modo tale che se non vi sono i relativi valori nel DB, il sistema non vada in crash
        $nome_careprovider = "";
        $cognome_careprovider = "";
        $telefono_careprovider = "";
        $citta_careprovider = "";
        $active_careprovider = "";

        $id_utente_careprovider = "";
        $comune_careprovider = "";
        
        //Se il valore dell'ID del careprovider richiesto non è nullo recupero i dati richiesti dalla specifica dal DB
        $nome_careprovider = getInfo('nome', 'careproviderpersona', 'id = ' . $careproviders);
        $cognome_careprovider = getInfo('cognome', 'careproviderpersona', 'id = ' . $careproviders);
        $telefono_careprovider = getInfo('telefono', 'careproviderpersona', 'id = ' . $careproviders);
        $citta_careprovider = getInfo('comune', 'careproviderpersona', 'id = ' . $careproviders);
        $active_careprovider = getInfo('active', 'careproviderpersona', 'id = ' . $careproviders);
        $id_utente_careprovider = getInfo('idutente', 'careproviderpersona', 'id = ' . $careproviders);
        $comune_careprovider = getInfo('comune', 'careproviderpersona', 'id = ' . $careproviders);
        

        //Creazione del documento XML per il CareProvider del Paziente

        //Creazione di un oggetto dom con la codifica UTF-8
        $dom = new \DOMDocument('1.0', 'utf-8');
        
        //Creazione del nodo Practitioner, cioè il nodo Root  della risorsa
        $careProvider = $dom->createElement('Practitioner');
        //Valorizzo il namespace della risorsa e del documento XML, in  questo caso la specifica FHIR
        $careProvider->setAttribute('xmlns', 'http://hl7.org/fhir');
        //Corrello l'elemento con il nodo superiore
        $careProvider = $dom->appendChild($careProvider);
        
        
        //Creazione del nodo ID sempre presente nelle risorse FHIR
        $id = $dom->createElement('id');
        //Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
        $id->setAttribute('value', $careproviders);
        $id = $careProvider->appendChild($id);
        
        
        //Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
        $narrative = $dom->createElement('text');
        //Corrello l'elemento con il nodo superiore
        $narrative = $careProvider->appendChild($narrative);
        
        
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
        //Corrello l'elemento con il nodo superiore
        $tbody = $table->appendChild($tbody);
        
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        
        //Creazione della colonna Name
        $td = $dom->createElement('td',"Name");
        $td = $tr->appendChild($td);
        
        
        //Creazione della colonna con il valore del nome e cognome del careprovider
        $td = $dom->createElement('td', $cognome_careprovider." ".$nome_careprovider);
        $td = $tr->appendChild($td);
        
        
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr =$tbody->appendChild($tr);
        
        
        //Creazione della colonna Contact
        $td = $dom->createElement('td',"Contact");
        $td = $tr->appendChild($td);
        
        
        //Creazione della colonna con il valore del numero di telefono del careprovider
        $td = $dom->createElement('td',$telefono_careprovider);
        $td = $tr->appendChild($td);
        
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        
        //Creazione della colonna City
        $td = $dom->createElement('td',"City");
        $td = $tr->appendChild($td);
        
        
        //Creazione della colonna con il valore della città di residenza del careprovider
        $td = $dom->createElement('td',$citta_careprovider);
        $td = $tr->appendChild($td);
        
        // creazione del nodo dell'extension del comune
        $node_extension_comune = $dom->createElement('extension');
        $node_extension_comune->setAttribute('url', 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/practitioner-comune.xml');
        $node_extension_comune = $careProvider->appendChild($node_extension_comune);

        $node_valueString = $dom->createElement('valueString');
        $node_valueString->setAttribute('value', $comune_careprovider);
        $node_valueString = $node_extension_comune->appendChild($node_valueString);

        // creazione del nodo dell'extension per l'id utente

        $node_extension_idutente = $dom->createElement('extension');
        $node_extension_idutente->setAttribute('url', 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/user-id.xml');
        $node_extension_idutente = $careProvider->appendChild($node_extension_idutente);

        $node_valueString = $dom->createElement('valueString');
        $node_valueString->setAttribute('value', $id_utente_careprovider);
        $node_valueString = $node_extension_idutente->appendChild($node_valueString);
            
        //Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
        $identifier = $dom->createElement('identifier');
        $identifier = $careProvider->appendChild($identifier);
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
        $value->setAttribute('value', "../fhir/Practitioner/".$careproviders);
        $value = $identifier->appendChild($value);
        
        
        //Creazione del nodo active settato al valore recuperato dal DB FSEM
        $active = $dom->createElement('active');
        if($active_careprovider=="1")
            $active->setAttribute('value', 'true');
        else
            $active->setAttribute('value', 'false');
        $active = $careProvider->appendChild($active);
        
        
        //Creazione del nodo name con il nominativo del care provider
        $name = $dom->createElement('name');
        $name = $careProvider->appendChild($name);
        //Creazione del nodo use settato sempre a usual
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'usual');
        $use = $name->appendChild($use);
        //Creazione del nodo family che indica il cognome del care provider
        $family = $dom->createElement('family');
        $family->setAttribute('value', $cognome_careprovider);
        $family = $name->appendChild($family);
        //Creazione del nodo given che indica il nome del care provider
        $given = $dom->createElement('given');
        $given->setAttribute('value', $nome_careprovider);
        $given = $name->appendChild($given);
        
        //Creazione del nodo telecom per il recapito telefonoco del care provider
        $telecom = $dom->createElement('telecom');
        $telecom = $careProvider->appendChild($telecom);
        //Creazione del nodo system che indica il tipo di recapito. valore sempre a phone
        $system = $dom->createElement('system');
        //Do il valore all' attributo del tag
        $system->setAttribute('value', 'phone');
        $system = $telecom->appendChild($system);
        //Creazione del nodo value per il valore del recapito telefonico
        $value = $dom->createElement('value');
        //Do il valore all' attributo del tag
        $value->setAttribute('value', $telefono_careprovider);
        $value = $telecom->appendChild($value);
        //Creazione del nodo use per capire se il numero è fisso o mobile
        $use = $dom->createElement('use');
        //Controllo se il primo carattere del numero è 3 in questo caso è un numero mobile altrimenti è un fisso
        if($telefono_careprovider[0]=="3")  
            $use->setAttribute('value', 'mobile');
        elseif( $telefono_careprovider[0]=="0")
            $use->setAttribute('value', 'home');
        $use = $telecom->appendChild($use);

        //Creazione del nodo communication per indicare la lingua di comunicazione del care provider
        $communication = $dom->createElement('communication');
        $communication = $careProvider->appendChild($communication);
        //Creazione del nodo coding
        $coding = $dom->createElement('coding');
        $coding = $communication->appendChild($coding);
        //Creazione del nodo system in cui si indica il value set dell' IETF
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'https://tools.ietf.org/html/bcp47');
        $system = $coding->appendChild($system);
        //Creazione del nodo code che indica il codice della lingua parlata, in questo caso l'italiano perche tutti i pazienti del FSEM usano l'italiano
        $code = $dom->createElement('code');
        $code->setAttribute('value', 'it');
        $code = $coding->appendChild($code);
        //Creazione del nodo display per visualizzazione testuale del valore della lingua
        $display = $dom->createElement('display');
        //Do il valore all' attributo del tag
        $display->setAttribute('value', 'Italiano');
        $display = $coding->appendChild($display);


        //Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
        $dom->preserveWhiteSpace = false;
        //Formattazione per l'output
        $dom->formatOutput = true;
        //Salvo il documento XML nella cartella rsources dando come nome, l'id del paziente
        //$dom->save("Practitioner/".$careproviders.".xml");
        
        return $dom->saveXML();

    }
}

?>