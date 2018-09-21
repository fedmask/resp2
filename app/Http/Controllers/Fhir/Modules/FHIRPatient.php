<?php

namespace App\Http\Controllers\Fhir\Modules;

use App\Http\Controllers\Fhir\Modules\FHIRResource;
use App\Models\Patient\Pazienti;
use App\Models\Patient\PazientiContatti;
use App\Models\CareProviders\CppPaziente;
use App\Exceptions\FHIR as FHIR;
use App\Models\CurrentUser\Recapiti;
use App\Models\CurrentUser\User;
use App\Models\Domicile\Comuni;
use Illuminate\Http\Request;
use App\Models\FHIR\PatientContact;
use App\Models\FHIR\ContactRole;
use App\Models\FHIR\PazienteCommunication;
use View;
use Illuminate\Filesystem\Filesystem;
use File;

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
	
	public function getResource($id){
	    // Recupero i dati del paziente
	    $patient = Pazienti::where('id_utente', $id)->first();
	    
	  /*  if (! $patient) {
	        throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
	    }
	    */
	    //Recupero i contatti del paziente
	  //  $patient_contacts = PatientContact::where('id_patient', $id)->get();
	    
	    //Recupero le lingue del paziente
	   // $patient_languages = PazienteCommunication::where('id_paziente', $patient->getID_Paziente())->get();
	    
	    // Recupero gli operatori sanitari del paziente
	  //  $careproviders = CppPaziente::where('id_paziente', $id)->get();
	    
	  // Sono i valori che verranno riportati nella parte descrittiva del documento
	  $values_in_narrative = array(
	      "Prova" => "OK",
	     /*   "Identifier" => "RESP-PATIENT"."-".$patient->getID_Paziente(),
	        "Active" => $patient->isActive(),
	        "Name" => $patient->getFullName(),
	        "Telecom" => $patient->getTelecom(),
	        "Gender" => $patient->getGender(),
	        "BirthDate" => $patient->getBirth(),
	        "Deceased" => $patient->isDeceased(),
	        "Address" => $patient->getAddress(),
	        "MaritalStatus" => $patient->getMaritalStatusDisplay(),
	        */
	   );
	   
	  //Patient.Contact
	/*  $narrative_patient_contact = array();
	    $count = 0;
	    foreach($patient->getContact() as $pc){
	        $count++;
	        $narrative_patient_contact["ContactName"." ".$count] = $pc->getName()." ".$pc->getSurname();
	        $narrative_patient_contact["ContactRelationship" ." ".$count] = $pc->getRelationshipDisplay();
	        $narrative_patient_contact["ContactTelecom"." ".$count] = $pc->getTelephone()." - ".$pc->getMail();   
	    }
	    
	    //Patient.Communication.language
	    $narrative_patient_language = array();
	    $count = 0;
	    foreach($patient->getCommunication() as $d){
	        $count++;
	        $narrative_patient_language["Language"." ".$count] = $d;
	    }
	    
	    
	    
	    // prelevo i dati dell'utente da mostrare come estensione
	    $custom_extensions = array(
	        'codicefiscale' => $patient->paziente_codfiscale,
	        'grupposanguigno' => $patient->paziente_gruppo." ".$patient->paziente_rh,
	        'donatoreorgani' => $patient->isDonatoreOrgani()
	    );
	  */  
	    $data_xml["narrative"] = $values_in_narrative;
	 /*   $data_xml["narrative_patient_contact"] = $narrative_patient_contact;
	    $data_xml["narrative_patient_language"] = $narrative_patient_language;
	    $data_xml["extensions"] = $custom_extensions;
	    $data_xml["patient"] = $patient;
	    //$data_xml["careproviders"] = $careproviders;
	    $data_xml["patient_contacts"] = $patient_contacts;
	    $data_xml["patient_languages"] = $patient_languages;
	   */ 
	    return view("pages.fhir.patient", [
	        "data_output" => $data_xml
	    ]);
	}

    function deleteResource($id) {
       
        if (!Pazienti::where('id_utente', $id)->exists()) {
            throw new IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }


        Pazienti::find($id)->delete();
    } 
    
    function updateResource($id, $xml) {
        $xml_values     = simplexml_load_string($xml);
        $json           = json_encode($xml_values);
        $array_data     = json_decode($json, true);

        if (!Pazienti::where('id_utente', $id)->exists()) {
            throw new IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
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
            throw new InvalidResourceFieldException('invalid care provider name and surname');
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
                    throw new InvalidResourceFieldException('an extension is missing');
            }
        }

        // prelevo la data di nascita
        if (!empty($array_data['birthDate']['@attributes']['value'])) {
            $db_values['datanascita'] = $array_data['birthDate']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid patient birthdate');
        }

        // prelevo l'indirizzo di residenza del paziente
        if (!empty($array_data['address']['line']['@attributes']['value'])) {
            $db_values['indirizzo'] = $array_data['address']['line']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid patient address field');
        }

        // prelevo il comune

        if (!empty($array_data['address']['city']['@attributes']['value'])) {
            $db_values['comunenascita'] = $array_data['address']['city']['@attributes']['value'];
            $db_values['comuneresidenza'] = $db_values['comunenascita'];
        } else {
            throw new InvalidResourceFieldException('invalid comune field');
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
            throw new InvalidResourceFieldException('invalid patient gender');
        }

        // prelevo il numero di telefono
        if (!empty($array_data['telecom']['value']['@attributes']['value'])) {
            $db_values['telefono'] = $array_data['telecom']['value']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid phone number');
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
            throw new IdFoundInCreateException('invalid id specified in CREATE');
        }

        // prelevo il nome del paziente
        if (!empty($array_data['name']['family']['@attributes']['value']) &&
            !empty($array_data['name']['given']['@attributes']['value'])) {
            $db_values['nome'] = $array_data['name']['family']['@attributes']['value'];
            $db_values['cognome'] = $array_data['name']['given']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid care provider name and surname');
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
                    throw new InvalidResourceFieldException('an extension is missing');
            }
        }

        // prelevo la data di nascita
        if (!empty($array_data['birthDate']['@attributes']['value'])) {
            $db_values['datanascita'] = $array_data['birthDate']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid patient birthdate');
        }

        // prelevo l'indirizzo di residenza del paziente
        if (!empty($array_data['address']['line']['@attributes']['value'])) {
            $db_values['indirizzo'] = $array_data['address']['line']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid patient address field');
        }

        // prelevo il comune

        if (!empty($array_data['address']['city']['@attributes']['value'])) {
            $db_values['comunenascita'] = $array_data['address']['city']['@attributes']['value'];
            $db_values['comuneresidenza'] = $db_values['comunenascita'];
        } else {
            throw new InvalidResourceFieldException('invalid comune field');
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
            throw new InvalidResourceFieldException('invalid patient gender');
        }

        // prelevo il numero di telefono
        if (!empty($array_data['telecom']['value']['@attributes']['value'])) {
            $db_values['telefono'] = $array_data['telecom']['value']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid phone number');
        }

        // controllo che nel database non esista un altro paziente con lo stesso username

        if (User::where('utente_nome', $db_values_user['username'])->exists()) {
            throw new UserAlreadyExistsException('cannot create resource Patient because username specified via extension already exists');
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
            throw new InvalidResourceFieldException('impossible to create username in database');
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

}
?>
