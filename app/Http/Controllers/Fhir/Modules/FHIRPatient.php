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
use App\Models\CodificheFHIR\ContactRelationship;
use App\Models\FHIR\PazienteCommunication;
use View;
use Illuminate\Filesystem\Filesystem;
use File;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Exception;
use DB;
use Redirect;
use Response;

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

class FHIRPatient {
    

	
	public function show($id){
	    // Recupero i dati del paziente
	    $patient = Pazienti::where('id_paziente', $id)->first();
	    
	    if (! $patient) {
	        throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
	    }
	  
	    //Recupero i contatti del paziente
	    $patient_contacts = PatientContact::where('id_patient', $id)->get();

	    
	    // Recupero gli operatori sanitari del paziente
	  //  $careproviders = CppPaziente::where('id_paziente', $id)->get();
	    
	  // Sono i valori che verranno riportati nella parte descrittiva del documento
	  $values_in_narrative = array(
	        "Identifier" => "RESP-PATIENT"."-".$patient->getID_Paziente(),
	        "Active" => $patient->isActive(),
	        "Name" => $patient->getFullName(),
	        "Telecom" => $patient->getTelecom(),
	        "Gender" => $patient->getGender(),
	        "BirthDate" => $patient->getBirth(),
	        "Deceased" => $patient->getDeceased(),
	        "Address" => $patient->getAddress(),
	        "MaritalStatus" => $patient->getMaritalStatusDisplay(),
	        "Language" => $patient->getLanguage(),
	   );
	   
	  //Patient.Contact
	  $narrative_patient_contact = array();
	    $count = 0;
	    foreach($patient->getContact() as $pc){
	        $count++;
	        $narrative_patient_contact["ContactName"." ".$count] = $pc->getName()." ".$pc->getSurname();
	        $narrative_patient_contact["ContactRelationship" ." ".$count] = $pc->getRelationshipDisplay();
	        $narrative_patient_contact["ContactTelecom"." ".$count] = $pc->getTelephone()." - ".$pc->getMail();   
	    } 
	    
	    // prelevo i dati dell'utente da mostrare come estensione
	    $custom_extensions = array(
	        'codicefiscale' => $patient->paziente_codfiscale,
	        'grupposanguigno' => $patient->paziente_gruppo." ".$patient->paziente_rh,
	        'donatoreorgani' => $patient->isDonatoreOrgani()
	    );
	    
	    $data_xml["narrative"] = $values_in_narrative;
	    $data_xml["narrative_patient_contact"] = $narrative_patient_contact;
	    $data_xml["extensions"] = $custom_extensions;
	    $data_xml["patient"] = $patient;
	    //$data_xml["careproviders"] = $careproviders;
	    $data_xml["patient_contacts"] = $patient_contacts;
	    
	    return view("pages.fhir.patient", [
	        "data_output" => $data_xml
	    ]);
	}

	public function store(Request $request){
	    
	    $file = $request->file('file');
	    
	    $xml = XmlParser::load($file->getRealPath());
	    
	    $id = $xml->parse(['identifier' => ['uses' => 'identifier.value::value']]);
	    
	    $pazienti = Pazienti::all();
	    
	    foreach($pazienti as $p){
	        if($p->id_paziente == $id['identifier']){
	            throw new Exception("Patient is already exists");
	        }
	    }
	    
	    $patient = $xml->parse([
	        'identifier' => ['uses' => 'identifier.value::value'],
	        'active' => ['uses' => 'active::value'],
	        'name' => ['uses' => 'name.given::value'],
	        'surname' => ['uses' => 'name.family::value'],
	        'telecom' => ['uses' => 'telecom[value::value]'],
	        'gender' => ['uses' => 'gender::value'],
	        'birthDate' => ['uses' => 'birthDate::value'],
	        'deceasedBoolean' => ['uses' => 'deceasedBoolean::value'],
	        'line' => ['uses' => 'address.line::value'],
	        'city' => ['uses' => 'address.city::value'],
	        'state' => ['uses' => 'address.state::value'],
	        'postalCode' => ['uses' => 'address.postalCode::value'],
	        'maritalStatus' => ['uses' => 'maritalStatus.coding.code::value'],
	        'communication' => ['uses' => 'communication.language.coding.code::value'],
	        'extension' => ['uses' => 'extension.valueBoolean::value'],
	        'ContRelCode' => ['uses' => 'contact[relationship.coding.code::value>attr]'],
	        'ContSurname' => ['uses' => 'contact[name.family::value>attr]'],
	        'ContName' => ['uses' => 'contact[name.given::value>attr]'],
	        'ContPhone' => ['uses' => 'contact[telecom.value::value>attr]'],
	        //TODO email
	        //TODP Patient.Contact
	        
	    ]);
	    
	    $contRelCode = array();
	    foreach($patient['ContRelCode'] as $cont){
	        array_push($contRelCode, $cont['attr']);
	    }
	    
	    $contSurname = array();
	    foreach($patient['ContSurname'] as $cont){
	        array_push($contSurname, $cont['attr']);
	    }
	    
	    $contName = array();
	    foreach($patient['ContName'] as $cont){
	        array_push($contName, $cont['attr']);
	    }
	    
	    $contPhone = array();
	    foreach($patient['ContPhone'] as $cont){
	        array_push($contPhone, $cont['attr']);
	    }
	    
	    
	    $telecom = array();
	    
	    foreach($patient['telecom'][0] as $p){
	        array_push($telecom ,$p);
	    }
	    
	    
	    foreach($patient['telecom'][1] as $p){
	        array_push($telecom ,$p);
	    }
	    
	    
	    $comune = Comuni::all()->where('comune_nominativo', $patient['city'])->first();
	    
	    
	    
	    $addUtente = User::create([
	        'utente_nome' => $patient['name']." ".$patient['surname'],
	        'id_tipologia'=> 'mos',
	        'utente_password' => bcrypt('test1234'),
	        'utente_stato' => '1',
	        'utente_scadenza' => '2030-01-01',
	        'utente_email' => $telecom[1],
	        'utente_dati_condivisione' => '1',
	        'utente_token_accesso' => ''
	        
	    ]);
	    
	    $addUtente->save();
	    
	    
	    $utente = User::all()->last();
	    
	    $addContatti = Recapiti::create([
	        'id_utente' => $utente->id_utente,
	        'id_comune_residenza' => $comune->id_comune,
	        'id_comune_nascita' => $comune->id_comune,
	        'contatto_telefono' => $telecom[0],
	        'contatto_indirizzo' => $patient['line'],
	    ]);
	    
	    
	    $addContatti->save();
	    
	    
	    $addPaziente = Pazienti::create([
	        'id_paziente' => $patient['identifier'],
	        'id_utente' => $utente->id_utente,
	        'paziente_nome' => $patient['name'],
	        'paziente_cognome' => $patient['surname'],
	        'paziente_nascita' => $patient['birthDate'],
	        'paziente_codfiscale' => '',
	        'paziente_sesso' => $patient['gender'],
	        'paziente_gruppo' => '',
	        'paziente_rh' => '',
	        'paziente_donatore_organi' => $patient['extension'],
	        'id_stato_matrimoniale' => $patient['maritalStatus'],
	        'paziente_lingua' => $patient['communication']
	    ]);
	    
	    $addPaziente->save();
	    
	    
	    $patientContact;
	    for ($i = 0; $i < sizeof($contRelCode); $i ++) {
	        $patientContact = PatientContact::create([
	            'Id_Patient' => $patient['identifier'],
	            'Relationship' => $contRelCode[$i],
	            'Name' => $contName[$i],
	            'Surname' => $contSurname[$i],
	            'Telephone' => $contPhone[$i],
	            'Mail' => ''
	        ]);
	        
	        $patientContact->save();
	    }
	    
	    return response()->json($patient['identifier'],201);
	    //return Redirect::back();
	}

}
?>
