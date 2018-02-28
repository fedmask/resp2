<?php

namespace App\Http\Controllers\Fhir\Modules;

use App\Exceptions\FHIR as FHIR;
use App\Http\Controllers\Fhir\Modules\FHIRResource;
use App\Models\Patient\Pazienti;
use App\Models\Patient\PazientiContatti;
use App\Models\CareProviders\CppPaziente;
/*
N.B.
la risorsa Patient utilizza diverse estensioni tra cui blood-type.
Ci sono estensioni che servono per acquisire informazioni sull'utente presente
nel sistema che e' legato al paziente, queste estensioni sono user-id e user-fields.

user-id: sara' utilizzata per aggiornare la risorsa quindi con user-id si
specifica semplicamente l'id dell'utente a cui corrisponde il paziente;
user-fields: e' invece una estensione che contiene tutti i campi della
tabella utenti presente nel database. Questa estensione sara' utilizzata in fase
di creazione e visualizzazione della risorsa in maniera tale da creare un
nuovo utente ogni qualvolta si crea un nuovo paziente nel sistema.
*/

class FHIRPatient extends FHIRResource {
    
	public function __construct() {}

    function deleteResource($id) {
       
        if (!Pazienti::where('id_utente', $id)->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }


        Pazienti::find($id)->delete();
    }

    function updateResource($id, $xml) {
        $xml_values     = simplexml_load_string($xml);
        $json           = json_encode($xml_values);
        $array_data     = json_decode($json, true);

        if (!Pazienti::where('id_utente', $id)->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        $db_values = array(
            'idutente' => '',
            'nome' => '',
            'cognome' => '',
            'datanascita' => '',
            'indirizzo' => '',
            'comunenascita' => '',
            'comuneresidenza' => '',
            'sesso' => '',
            'grupposanguigno' => '',
            'telefono' => '',
        );

        $encrypted_values = array();

        # -----------------------------------------
        # PARSO I DATI DAL DOCUMENTO XML

        // controllo che l'id passato come URL coincida con il campo id della
        // risorsa xml passata come input

        if ($id != $array_data['id']['@attributes']['value']) {
            throw new MatchException('ID provided in url doesn\'t match the one in XML resource');
        }

        // prelevo il nome del paziente
        if (!empty($array_data['name']['family']['@attributes']['value']) &&
            !empty($array_data['name']['given']['@attributes']['value'])) {
            $db_values['nome'] = $array_data['name']['given']['@attributes']['value'];
            $db_values['cognome'] = $array_data['name']['family']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid care provider name and surname');
        }

        // prelevo i campi delle estensioni
        foreach($array_data['extension'] as $extension_element) {
            switch ($extension_element['@attributes']['url']) {
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/user-id.xml':
                    $db_values['idutente'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/blood-type.xml';
                    $db_values['grupposanguigno'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                default:
                    throw new FHIR\InvalidResourceFieldException('an extension is missing');
            }
        }

        // prelevo la data di nascita
        if (!empty($array_data['birthDate']['@attributes']['value'])) {
            $db_values['datanascita'] = $array_data['birthDate']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid patient birthdate');
        }

        // prelevo l'indirizzo di residenza del paziente
        if (!empty($array_data['address']['line']['@attributes']['value'])) {
            $db_values['indirizzo'] = $array_data['address']['line']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid patient address field');
        }

        // prelevo il comune

        if (!empty($array_data['address']['city']['@attributes']['value'])) {
            $db_values['comunenascita'] = $array_data['address']['city']['@attributes']['value'];
            $db_values['comuneresidenza'] = $db_values['comunenascita'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid comune field');
        }

        // prelevo il genere del paziente
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

        // prelevo il numero di telefono
        if (!empty($array_data['telecom']['value']['@attributes']['value'])) {
            $db_values['telefono'] = $array_data['telecom']['value']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid phone number');
        }


        # -----------------------------------------
        # INSERISCO I DATI PARSATI NEL DATABASE

        $paziente = Paziente::find($id);
        
        $paziente->paziente_nome = $db_values['nome'];
        $paziente->paziente_cognome = $db_values['cognome'];
        $paziente->paziente_nascita = $db_values['datanascita'];
        $paziente->paziente_sesso = $db_values['sesso'];
        $paziente->paziente_gruppo = $db_values['grupposanguigno'];
        $paziente->paziente_donatore_organi = 0;
        
        $paziente->user()->first()->contacts()->first()->utente_indirizzo = $db_values['indirizzo'];
        $paziente->user()->first()->contacts()->first()->utente_telefono  = $db_values['telefono'];
        
        $comune_nascita     = Comuni::where('comune_nominativo', $encrypted_values['comunenascita'])->first();
        $comune_residenza   = Comuni::where('comune_nominativo', $encrypted_values['comuneresidenza'])->first();
        
        $paziente->user()->first()->contacts()->first()->id_comune_residenza = $comune_residenza->id_comune;
        $paziente->user()->first()->contacts()->first()->id_comune_nascita   = $comune_nascita->id_comune;
        
        $paziente->save();
    }

	function createResource($xml) {

		// converto il documento in formato json
        // per accedere facilmente alla struttura con un
        // array associativo php
        $xml_values = simplexml_load_string($xml);
        $json = json_encode($xml_values);
        $array_data = json_decode($json, true);

        $db_values = array(
            'idutente' => '',
            'nome' => '',
            'cognome' => '',
            'datanascita' => '',
            'indirizzo' => '',
            'comunenascita' => '',
            'comuneresidenza' => '',
            'sesso' => '',
            'grupposanguigno' => '',
            'telefono' => '',
        );

        // valori del database dell'utente a cui corrisponde la risorsa Patient

        $db_values_user = array(
            'id' => '',
            'username' => '',
            'password' => '',
   //         'pin' => '',
            'codicefiscale' => '',
            'stato' => '',
            'scadenza' => '',
            'codiceruolo' => '',
            'email' => '',
    //        'active' => '',
    //        'confKey' => '',

     //       'salt' => '',
        );

        $encrypted_values = array();

        # -----------------------------------------
        # PARSO I DATI DAL DOCUMENTO XML

        if (!empty($array_data['id']['@attributes']['value'])) {
            throw new FHIR\IdFoundInCreateException('invalid id specified in CREATE');
        }

        // prelevo il nome del paziente
        if (!empty($array_data['name']['family']['@attributes']['value']) &&
            !empty($array_data['name']['given']['@attributes']['value'])) {
            $db_values['nome'] = $array_data['name']['family']['@attributes']['value'];
            $db_values['cognome'] = $array_data['name']['given']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid care provider name and surname');
        }

        // prelevo i campi delle estensioni
        foreach($array_data['extension'] as $extension_element) {
            switch ($extension_element['@attributes']['url']) {
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/user-fields.xml':

                    // itero su tutte le altre sotto estensioni dell'estensione user-fields
                    // in maniera da prelevare gli altri campi per la creazione del nuovo utente
                    foreach($extension_element['extension'] as $inner_ext) {
                        switch ($inner_ext['@attributes']['url']) {
                            case 'username':
                                $db_values_user['username'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'password':
                                $db_values_user['password'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'pin':
                                $db_values_user['pin'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'codicefiscale':
                                $db_values_user['codicefiscale'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'stato':
                                $db_values_user['stato'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'scadenza':
                                $db_values_user['scadenza'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'codiceruolo':
                                $db_values_user['codiceruolo'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'email':
                                $db_values_user['email'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            /*
                            case 'active':
                                $db_values_user['active'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'confKey':
                                $db_values_user['confKey'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'salt':
                                $db_values_user['salt'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            */
                            default:
                                throw new InvalidResourceFieldException('an inner extension is missing');
                        }
                    }

                    break;
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/blood-type.xml';
                    $db_values['grupposanguigno'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                default:
                    throw new FHIR\InvalidResourceFieldException('an extension is missing');
            }
        }

        // prelevo la data di nascita
        if (!empty($array_data['birthDate']['@attributes']['value'])) {
            $db_values['datanascita'] = $array_data['birthDate']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid patient birthdate');
        }

        // prelevo l'indirizzo di residenza del paziente
        if (!empty($array_data['address']['line']['@attributes']['value'])) {
            $db_values['indirizzo'] = $array_data['address']['line']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid patient address field');
        }

        // prelevo il comune

        if (!empty($array_data['address']['city']['@attributes']['value'])) {
            $db_values['comunenascita'] = $array_data['address']['city']['@attributes']['value'];
            $db_values['comuneresidenza'] = $db_values['comunenascita'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid comune field');
        }

        // prelevo il genere del paziente
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

        // prelevo il numero di telefono
        if (!empty($array_data['telecom']['value']['@attributes']['value'])) {
            $db_values['telefono'] = $array_data['telecom']['value']['@attributes']['value'];
        } else {
            throw new FHIR\InvalidResourceFieldException('invalid phone number');
        }

        // controllo che nel database non esista un altro paziente con lo stesso username

        if (User::where('utente_nome', $db_values_user['username'])->exists()) {
            throw new FHIR\UserAlreadyExistsException('cannot create resource Patient because username specified via extension already exists');
        }

        # -----------------------------------------
        # INSERISCO I DATI PARSATI NEL DATABASE

        // per prima cosa creo il nuovo utente a cui associare la risorsa Patient

        $utente = new User();
        
        $utente->utente_nome = $db_values_user['username'];
        $utente->utente_password = $db_values_user['password'];
        $utente->utente_email = $db_values_user['email'];
        $utente->utente_stato = $db_values_user['stato'];
        $utente->utente_scadenza = $db_values_user['scadenza'];
        $utente->utente_ruolo = $db_values_user['codiceruolo'];
        
        $utente->save();
        
        $utente = User::find('utente_nome', $db_values_user['username'])->first();
        
        // se tutto e' andato a buon fine, prelevo l'id del nuovo record appena creato nel database per l'utente

        $db_values_user['id'] = $utente->id_utente;

        if (!$db_values_user['id']) {
            throw new FHIR\InvalidResourceFieldException('impossible to create username in database');
        }

        $db_values['idutente'] = $db_values_user['id'];

		// inserisco i dati effettivi del paziente nel database

        $paziente = new Pazienti();
        
        $paziente->paziente_codfiscale  = $db_values_user['codicefiscale'];
        $paziente->id_utente            = $db_values['idutente'];
        $paziente->paziente_nome        = $data_values['nome'];
        $paziente->paziente_cognome     = $data_values['cognome'];
        $paziente->paziente_nascita     = $data_values['datanascita'];
        $paziente->paziente_sesso       = $data_values['sesso'];
        $paziente->paziente_gruppo      = $data_values['grupposanguigno'];
        
        $paziente->save();
        
        $utente_recapiti                = new Recapiti();
        
        $utente_recapiti->contatto_telefono  = $data_values['telefono'];
        $utente_recapiti->contatto_indirizzo = $data_values['indirizzo'];
        $utente_recapiti->id_utente          = $db_values['idutente'];
        
        $comune_nascita     = Comuni::where('comune_nominativo', $encrypted_values['comunenascita'])->first();
        $comune_residenza   = Comuni::where('comune_nominativo', $encrypted_values['comuneresidenza'])->first();

        $utente_recapiti->id_comune_nascita   = $comune_nascita->id_comune;
        $utente_recapiti->id_comune_residenza = $comune_residenza->id_comune;
        
        return $db_values['idutente'];
	}

	function getResource($id)
	{

		//Recupero i dati del paziente avente l' ID richiesto
		$idutente = $id;
		$paziente = Pazienti::where('id_utente', $id)->first();
		$contatti = PazientiContatti::where('id_paziente', $id)->get();
		$careproviders = CppPaziente::where('id_paziente', $id)->get();
		
		if (!$paziente) {
		    throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        // prelevo i dati dell'utente da mostrare come estensione
        $db_values = array(
            'username' => $paziente->user->utente_nome,
            'password' => $paziente->user->utente_password,
            //'pin' => getInfo('pin', 'utenti', 'id = ' . $idutente),
            'codicefiscale' => $paziente->paziente_codfiscale,
            'stato' => $paziente->user->stato,
            'scadenza' => $paziente->user->utente_scadenza,
            'codiceruolo' => $paziente->user->id_tipologia,
            'email' => $paziente->user->utente_email,
            //'active' => getInfo('active', 'utenti', 'id = ' . $idutente),
            //'confKey' => getInfo('confKey', 'utenti', 'id = ' . $idutente),
            //'salt' => '',
        );

  		//Creazione del documento XML per il paziente

		//Creazione di un oggetto dom con la codifica UTF-8
		$dom = new \DOMDocument('1.0', 'utf-8');

		//Creazione del nodo Patient, cioè il nodo Root  della risorsa
		$patient = $dom->createElement('Patient');
		//Valorizzo il namespace della risorsa e del documento XML, in  questo caso la specifica FHIR
		$patient->setAttribute('xmlns', 'http://hl7.org/fhir');
		//Corrello l'elemento con il nodo superiore
		$patient = $dom->appendChild($patient);


		//Creazione del nodo ID sempre presente nelle risorse FHIR
		$id = $dom->createElement('id');
		//Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
		$id->setAttribute('value', $idutente);
		$id = $patient->appendChild($id);


		//Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
		$narrative = $dom->createElement('text');
		//Corrello l'elemento con il nodo superiore
		$narrative = $patient->appendChild($narrative);


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

		//Creazione della colonna Name
		$td = $dom->createElement('td',"Name");
		$td = $tr->appendChild($td);

		//Creazione della colonna con il valore di nome e cognome del paziente
		$td = $dom->createElement('td', $paziente->paziente_nome." ".$paziente->paziente_cognome);
		$td = $tr->appendChild($td);


		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr = $tbody->appendChild($tr);


		//Creazione della colonna BirthDate
		$td = $dom->createElement('td',"BirthDate");
		$td = $tr->appendChild($td);


		//Creazione della colonna con il valore di data di nascita del paziente
		$td = $dom->createElement('td', $paziente->paziente_nascita);
		$td = $tr->appendChild($td);


		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr =$tbody->appendChild($tr);


		//Creazione della colonna Contact
		$td = $dom->createElement('td',"Contact");
		$td = $tr->appendChild($td);


		//Creazione della colonna con il valore del contatto telefonico

		$td = $dom->createElement('td',$paziente->user()->first()->contacts()->first()->contatto_telefono);
		$td = $tr->appendChild($td);


		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr = $tbody->appendChild($tr);


		//Creazione della colonna City
		$td = $dom->createElement('td',"City");
		$td = $tr->appendChild($td);


		//Creazione della colonna con il valore del comune di residenza
		$td = $dom->createElement('td',$paziente->user()->first()->contacts()->first()->id_comune_residenza);
		$td = $tr->appendChild($td);


		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr = $tbody->appendChild($tr);


		//Creazione della colonna Address
		$td = $dom->createElement('td',"Address");
		$td = $tr->appendChild($td);


		///Creazione della colonna con il valore dell'indirizzo
		$td = $dom->createElement('td',$paziente->user()->first()->contacts()->first()->contatto_indirizzo);
		$td = $tr->appendChild($td);


		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr = $tbody->appendChild($tr);


		//Creazione della colonna State
		$td = $dom->createElement('td',"State");
		$td = $tr->appendChild($td);


		//Creazione della colonna con il valore dello stato di residenza
		$td = $dom->createElement('td', "Italia IT");
		$td = $tr->appendChild($td);


		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr = $tbody->appendChild($tr);


		//Creazione della colonna Marital Status
		$td = $dom->createElement('td',"Marital Status");
		$td = $tr->appendChild($td);


		//Creazione della colonna con il valore di stato civile
		$td = $dom->createElement('td',$paziente->id_stato_matrimoniale);
		$td = $tr->appendChild($td);


        // creo l'estensione per indicare il gruppo sanguigno
        $node_extension = $dom->createElement('extension');
        $node_extension->setAttribute('url', 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/blood-type.xml');
        $node_extension = $patient->appendChild($node_extension);

        $node_valueString = $dom->createElement('valueString');
        $node_valueString->setAttribute('value', $paziente->paziente_gruppo);
        $node_valueString = $node_extension->appendChild($node_valueString);

        
        // creazione del nodo extension che rappresenta i vari campi dell'utente a cui
        // corrisponde il paziente della risorsa

        $node_extension_fields = $dom->createElement('extension');
        $node_extension_fields->setAttribute('url', 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/user-fields.xml');
        $node_extension_fields = $patient->appendChild($node_extension_fields);

        foreach($db_values as $i => $value) {
            $node_inner_extension = $dom->createElement('extension');
            $node_inner_extension->setAttribute('url', $i);
            $node_inner_extension = $node_extension_fields->appendChild($node_inner_extension);

            $node_valueString = $dom->createElement('valueString');
            $node_valueString->setAttribute('value', $value);
            $node_valueString = $node_inner_extension->appendChild($node_valueString);
        }

        
		//Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
		$identifier = $dom->createElement('identifier');
		$identifier = $patient->appendChild($identifier);
		//Creazione del nodo use con valore fisso ad usual
		$use = $dom->createElement('use');
		$use->setAttribute('value', 'usual');
		$use = $identifier->appendChild($use);
		//Creazione del nodo system che identifica il namespace degli URI per identificare la risorsa
		$system = $dom->createElement('system');
		$system->setAttribute('value', 'urn:ietf:rfc:3986');  //RFC gestione URI
		$system = $identifier->appendChild($system);
		//Creazione del nodo value
		$value = $dom->createElement('value');
		//Do il valore all' URI della risorsa
		$value->setAttribute('value', "../fhir/Patient/".$idutente);
		$value = $identifier->appendChild($value);

		
		
		//Creazione del nodo active settato a true in quanto la risorsa è attiva per il FSEM
		$active = $dom->createElement('active');
		$active->setAttribute('value', 'true');
		$active = $patient->appendChild($active);
		

		//Creazione del nodo per il nominativo del paziente
		$name = $dom->createElement('name');
		$name = $patient->appendChild($name);
		//Creazione del nodo use settato sempre al valore usual
		$use = $dom->createElement('use');
		$use->setAttribute('value', 'usual');
		$use = $name->appendChild($use);
		//Creazione del nodo family che indica il nome dalla famiglia di provenienza, quindi il cognome del paziente
		$family = $dom->createElement('family');
		$family->setAttribute('value', $paziente->paziente_cognome);
		$family = $name->appendChild($family);
		//Creazione del nodo given che indica il nome di battesimo dato al paziente
		$given = $dom->createElement('given');
		$given->setAttribute('value', $paziente->paziente_nome);
		$given = $name->appendChild($given);

		
		//Creazione del nodo telecom con il contatto telefonico del paziente
		$telecom = $dom->createElement('telecom');
		$telecom = $patient->appendChild($telecom);
		//Creazione del nodo system che indica che il contatto è un valore telefonico
		$system = $dom->createElement('system');
		$system->setAttribute('value', 'phone');
		$system = $telecom->appendChild($system);
		//Creazione del nodo value che contiene il valore del numero di telefono del paziente
		$value = $dom->createElement('value');
		$value->setAttribute('value', $paziente->user()->first()->contacts()->first()->contatto_telefono);
		$value = $telecom->appendChild($value);
		//Creazione del nodo use che indica la tipologia di numero di telefono
		$use = $dom->createElement('use');
		//Contro se il numero di telefono è di un mobile o fisso
		if($paziente->user()->first()->contacts()->first()->contatto_telefono[0]=="3")
			$use->setAttribute('value', 'mobile');
		else
			$use->setAttribute('value', 'home');
		
		$use = $telecom->appendChild($use);


		//Creazione del nodo gender per il sesso del paziente
		$gender = $dom->createElement('gender');
		//Controllo se il sesso salvato nel FSEM sia maschio o femmina e do il valore all'attributo con codifica HL7
		$gender->setAttribute('value', $paziente->paziente_sesso);
		$gender = $patient->appendChild($gender);


		//Creazione del nodo birthdate con la data di nascita del paziente
		$birthDate = $dom->createElement('birthDate');
		$birthDate->setAttribute('value', $paziente->paziente_nascita);
		$birthDate = $patient->appendChild($birthDate);


		//Effettuo il controllo sulla data di decesso del paziente
		if(!$paziente->tbl_pazienti_decessi()->first())
		{
			//Se la data di decesso non esiste allora setto a false il valore del nodo deceasedBoolean
			$deceasedBoolean = $dom->createElement('deceasedBoolean');
			$deceasedBoolean->setAttribute('value', 'false');
			$deceasedBoolean = $patient->appendChild($deceasedBoolean);
		}
		else
		{
			//Se la data di decesso esiste allora la inserisco
			$deceasedDateTime = $dom->createElement('deceasedDateTime');
			$deceasedDateTime->setAttribute('value', $paziente->tbl_pazienti_decessi()->first()->paziente_data_decesso);
			$deceasedDateTime = $patient->appendChild($deceasedDateTime);
		}


		//Creazione del nodo address per i dati relativi al recapito del paziente
		$address = $dom->createElement('address');
		$address = $patient->appendChild($address);
		//Creazione del nodo use che indica che il recapito è relativo alla casa di residenza
		$use = $dom->createElement('use');
		$use->setAttribute('value', 'home');
		$use = $address->appendChild($use);
		
		//Creazione del nodo line che indica l'indirizzo di residenza
		$line = $dom->createElement('line');
		$line->setAttribute('value', $paziente->user()->first()->getAddress());
		$line = $address->appendChild($line);
		//Creazione del nodo city che indica la città di residenza
		$city = $dom->createElement('city');
		$city->setAttribute('value', $paziente->user()->first()->getLivingTown());
		$city = $address->appendChild($city);
	
		//Creazione del nodo postalCode che indica il codice postale di residenza
		$postalCode = $dom->createElement('postalCode');
		$postalCode->setAttribute('value', $paziente->user()->first()->getCapLivingTown());
		$postalCode = $address->appendChild($postalCode);
		
		//Creazione del nodo country che indica lo stato di residenza
		$country = $dom->createElement('country');
		$country->setAttribute('value', $paziente->user()->first()->contacts()->first()->town()->first()->tbl_nazioni()->first()->getCountryName());
		$country = $address->appendChild($country);

		//Creazione del nodo maritalStatus cioè lo stato civile del paziente
		$maritalStatus = $dom->createElement('maritalStatus');
		$maritalStatus = $patient->appendChild($maritalStatus);
		//Creazione del nodo coding che indica la codifica usata
		$coding = $dom->createElement('coding');
		$coding = $maritalStatus->appendChild($coding);
		//Creazione del nodo system che indica il value set da cui confrontare la validità dei codici
		$system = $dom->createElement('system');
		$system->setAttribute('value', "http://hl7.org/fhir/v3/MaritalStatus"); //value set HL7
		$system = $coding->appendChild($system);
		//Creazione del nodo code con codice dello stato civile
		$code = $dom->createElement('code');
		$code->setAttribute('value', $paziente->user()->first()->utente_stato);
		$code = $coding->appendChild($code);
		//Creazione del nodo dysplay cioè la visualizzazione dello stato civile
		$dysplay = $dom->createElement('display');
		//Do il valore all' attributo del tag
		$dysplay->setAttribute('value', $paziente->user()->first()->getMaritalStatus() );
		$dysplay = $coding->appendChild($dysplay);


		//Controllo che ci sia una foto relativa al paziente

		/**
		 * @TODO: Il caricamento delle foto non funziona
		if($foto!=""){
			//Creazione del nodo photo se esiste la foto del paziente
			$photo = $dom->createElement('photo');
			$photo = $patient->appendChild($photo);
			//Creazione del nodo contentType che indica l'estensione e quindi il tipo di foto
			$contentType = $dom->createElement('contentType');
			$contentType->setAttribute('value', 'image/jpeg');
			$contentType = $photo->appendChild($contentType);
			//Creazione del nodo url che contiene l'indirizzo in cui si trova la foto
			$url = $dom->createElement('url');
			$url->setAttribute('value', "../files/uploads/".$foto);
			$url = $photo->appendChild($url);
			$data->setAttribute('value', $foto);
			$data = $photo->appendChild($data);
		}
        */


		//Inserisco tutti i contatti di emergenza in quanto possono essere più di uno
		foreach ($contatti as $contatto){

			$contact = $dom->createElement('contact');
			$contact = $patient->appendChild($contact);
			//Creazione del nodo relationship indicante la relazione che intercorre fra paziente e contatto
			$relationship = $dom->createElement('relationship');
			$relationship = $contact->appendChild($relationship);
			$coding = $dom->createElement('coding');
			$coding = $relationship->appendChild($coding);
			//Creazione del nodo system dal quale recupero il value set delle tipologie di contatti
			$system = $dom->createElement('system');
			$system->setAttribute('value', 'http://hl7.org/fhir/patient-contact-relationship');
			$system = $coding->appendChild($system);
			//Creazione del nodo code avente il valore della tipologia di contatto
			$code = $dom->createElement('code');
			$code->setAttribute('value', $contatto->contacts_type()->first()->tipologia_nome);
			$code = $coding->appendChild($code);
			//Creazione del nodo name con il nominativo del contatto
			$name = $dom->createElement('name');
			$name = $contact->appendChild($name);
			//Creazione del nodo use settato sempre a usual
			$use = $dom->createElement('use');
			//Do il valore all' attributo del tag
			$use->setAttribute('value', 'usual');
			$use = $name->appendChild($use);
			//Creazione del nodo text in cui inserisco il valore del nominativo del contatto
			$text = $dom->createElement('text');
			$text->setAttribute('value', $contatto->contatto_nominativo);
			$text = $name->appendChild($text);
			//Creazione del nodo telecom per il recapito del contatto di emergenza
			$telecom = $dom->createElement('telecom');
			$telecom = $contact->appendChild($telecom);
			//Creazione del nodo system che indica che il recapito è un numero telefonico
			$system = $dom->createElement('system');
			$system->setAttribute('value', 'phone');
			$system = $telecom->appendChild($system);
			//Creazione del nodo value contenente il numero telefonico del contatto
			$value = $dom->createElement('value');
			$value->setAttribute('value', $contatto->contatto_telefono);
			$value = $telecom->appendChild($value);
			//Creazione del nodo use che indica se il numero di telefono è fisso o mobile
			$use = $dom->createElement('use');
			//Controllo se il primo carattere del numero è 3 e in questo caso è un numero mobile altrimenti è un fisso
			
			if($contatto->contatto_telefono[0]=="3")
				$use->setAttribute('value', 'mobile');
				elseif($contatto->contatto_telefono[0]=="0")
				$use->setAttribute('value', 'home');
			$use = $telecom->appendChild($use);

		}

		//Creazione del nodo communication per indicare la lingua di comunicazione del paziente
		$communication = $dom->createElement('communication');
		$communication = $patient->appendChild($communication);
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

		foreach ($careproviders as $cpp){
		    //Creazione del nodo careProvider che è in relazione alla risorsa Practitioner
		    $careProvider = $dom->createElement('careProvider');
		    $careProvider = $patient->appendChild($careProvider);
		    //Creazione del nodo reference per inserire il riferimento alla relativa risorsa Practitioner
		    $reference = $dom->createElement('reference');
		    $reference->setAttribute('value', "../fhir/Practitioner/".$cpp->id_cpp);
		    $reference = $careProvider->appendChild($reference);
		}

		//Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
		$dom->preserveWhiteSpace = false;
		//Formatto il documento per l'output
		$dom->formatOutput = true;
		//Salvo il documento XML nella cartella rsources dando come nome, l'id del paziente
		//$dom->save("../fhir/Patient/".$idutente.".xml");

		echo $dom->saveXML();
		//return $dom->saveXML();
	}
}
?>
