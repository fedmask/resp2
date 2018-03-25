<?php

namespace App\Http\Controllers\Fhir\Modules;

use App\Exceptions\FHIR as FHIR;
use App\Models\Patient\Pazienti;
use App\Models\CurrentUser\Recapiti;
use App\Models\CurrentUser\User;
use App\Models\Patient\PazientiContatti;
use App\Models\Domicile\Comuni;
use App\Models\CareProviders\CppPaziente;
use Illuminate\Http\Request;

class FHIRPatient {
    
    
	function show($id_patient){
	    
	    //Recupero i dati del paziente
	    $paziente = Pazienti::where('id_utente', $id_patient)->first();
	    
	    if (!$paziente) {
	        throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
	    }

	    //Recupero i contatti di emergenza del paziente
	    $contatti = PazientiContatti::where('id_paziente', $id_patient)->get();
	    
	    //Recupero gli operatori sanitari del paziente
	    $careproviders = CppPaziente::where('id_paziente', $id_patient)->get();
	    
	    //Sono i valori che verranno riportati nella parte descrittiva del documento
	    //Indicare CHIAVE e VALORE di ogni riga (es: Nome => "Antonio Rossi")
	    $values_in_narrative = array(
	        "Name"             => $paziente->paziente_nome." ".$paziente->paziente_cognome,
	        "BirthDate"        => $paziente->paziente_nascita,
	        "Contact"          => $paziente->user()->first()->contacts()->first()->contatto_telefono,
	  //      "City"             => $paziente->getTown(), /* $paziente->user()->first()->contacts()->first()->id_comune_residenza,*/
	        "Address"          => $paziente->user()->first()->contacts()->first()->contatto_indirizzo,
	        "State"            => "Italia IT",
	        "Marital Status"   => $paziente->getStatusWedding()
	    );

	    // prelevo i dati dell'utente da mostrare come estensione
	    $custom_extensions = array(
	        'username'         => $paziente->user->utente_nome,
	        'password'         => $paziente->user->utente_password,
	        'codicefiscale'    => $paziente->paziente_codfiscale,
	        'stato'            => $paziente->user->stato,
	        'scadenza'         => $paziente->user->utente_scadenza,
	        'codiceruolo'      => $paziente->user->id_tipologia,
	        'email'            => $paziente->user->utente_email,
	    );
	    
	    $data_xml["narrative"]     = $values_in_narrative;
	    $data_xml["extensions"]    = $custom_extensions;
	    $data_xml["patient"]       = $paziente;
	    $data_xml["careproviders"] = $careproviders;
	    $data_xml["contacts"]      = $contatti;

        return view("fhir.patient", ["data_output" => $data_xml]);
	}
	
	function destroy($id_patient) {

	    $patient = Pazienti::find($id_patient);

	    if (!$patient->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        Pazienti::find($id_patient)->delete();
    }


    function store(Request $request) {

        $doc = new \SimpleXMLElement($request->getContent());
        
        $patient_data   = Pazienti::find($doc->id["value"]);
        $datafrom_email = $doc->extension[1]->extension[6]->valueString["value"];
        $datafrom_pass  = $doc->extension[1]->extension[1]->valueString["value"];
        $datafrom_name  = $doc->extension[1]->extension[0]->valueString["value"];
        
        /** VERIFICO LA PRESENZA DI ALCUNI DATI NECESSARI PER LA REGISTRAZIONE **/
        
        if ($patient_data) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided exists in database !");
        }

        if (empty($datafrom_email)) {
            throw new FHIR\InvalidResourceFieldException("email cannot be empty !");
        }
        
        if (empty($datafrom_name)) {
            throw new FHIR\InvalidResourceFieldException("username cannot be empty !");
        }
        
        if (empty($datafrom_pass)) {
            throw new FHIR\InvalidResourceFieldException("password cannot be empty !");
        }
        
        /** VALIDAZIONE ANDATA A BUON FINE - CREO IL PAZIENTE E L'UTENTE ASSOCIATO **/
        
        $user = new User();

        $user->id_tipologia     = User::PATIENT_ID;
        $user->utente_nome      = $datafrom_name;
        $user->utente_password  = $datafrom_pass;
        $user->utente_stato     = 1;
        $user->utente_email     = $datafrom_email;

        $user->save();
        
        $patient = new Pazienti;
        $patient->id_utente                    = $user->id_utente;
        $patient->paziente_nome                = $doc->name->given["value"];
        $patient->paziente_cognome             = $doc->name->family["value"];
        $patient->paziente_nascita             = $doc->birthDate["value"];
        $patient->paziente_sesso               = $doc->gender["value"];
        $patient->paziente_codfiscale          = $doc->extension[1]->extension[3]->valueString["value"];
        $patient->paziente_donatore_organi     = 0;
        
        $patient->save();
    }

    function update(Request $request, $id) {

        $doc = new \SimpleXMLElement($request->getContent());

        $patient_data   = Pazienti::find($doc->id["value"])->first();
        $datafrom_email = $doc->extension[1]->extension[6]->valueString["value"];
        $datafrom_pass  = $doc->extension[1]->extension[1]->valueString["value"];
        $datafrom_name  = $doc->extension[1]->extension[0]->valueString["value"];
        
        /** VERIFICO LA PRESENZA DI ALCUNI DATI NECESSARI PER LA REGISTRAZIONE **/
        
        if (!$patient_data) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id dont exists in database !");
        }
        
        if (empty($datafrom_email)) {
            throw new FHIR\InvalidResourceFieldException("email cannot be empty !");
        }
        
        if (empty($datafrom_name)) {
            throw new FHIR\InvalidResourceFieldException("username cannot be empty !");
        }
        
        if (empty($datafrom_pass)) {
            throw new FHIR\InvalidResourceFieldException("password cannot be empty !");
        }
        
        /** VALIDAZIONE ANDATA A BUON FINE - AGGIORNO IL PAZIENTE E L'UTENTE ASSOCIATO **/

        $patient_data->paziente_nome                = $doc->name->given["value"];
        $patient_data->paziente_cognome             = $doc->name->family["value"];
        $patient_data->paziente_nascita             = $doc->birthDate["value"];
        $patient_data->paziente_sesso               = $doc->gender["value"];
        $patient_data->paziente_codfiscale          = $doc->extension[1]->extension[2]->valueString["value"];
        $patient_data->paziente_donatore_organi     = 0;

        $user = User::find($patient_data->id_utente)->first();
        
        $user->id_tipologia     = User::PATIENT_ID;
        $user->utente_nome      = $datafrom_name;
        $user->utente_password  = $datafrom_pass;
        $user->utente_stato     = 1;
        $user->utente_email     = $datafrom_email;
        
        $user->save();
        $patient_data->save();
	}
}
?>
