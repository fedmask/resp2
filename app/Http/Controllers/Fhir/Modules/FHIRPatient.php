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

/**
 * Implementazione dei servizi REST:
 * show     -> GET
 * destroy  -> DELETE
 * store    -> POST
 * update   -> PUT
 * 
 * I metodi lavorano con il file XML secondo lo standard FHIR
 */

class FHIRPatient {
    
	public function show($id){
	    
	    //Recupero i dati del paziente
	    $patient = Pazienti::where('id_utente', $id)->first();
	    
	    if (!$patient) {
	        throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
	    }

	    //Recupero i contatti di emergenza del paziente
	    $contacts = PazientiContatti::where('id_paziente', $id)->get();
	    
	    //Recupero gli operatori sanitari del paziente
	    $careproviders = CppPaziente::where('id_paziente', $id)->get();
	    
	    //Sono i valori che verranno riportati nella parte descrittiva del documento
	    //Indicare CHIAVE e VALORE di ogni riga (es: Nome => "Antonio Rossi")
	    $values_in_narrative = array(
	        "Name"             => $patient->getFullName(),
	        "BirthDate"        => $patient->getBirth(),
	        "Contact"          => $patient->getPhone(),
	        "City"             => $patient->getCity(),
	        "Address"          => $patient->getLine(),
	        "State"            => "Italia IT",         //Al momento è un vincolo RESP
	        "Marital Status"   => $patient->getStatusWedding()
	    );

	    // prelevo i dati dell'utente da mostrare come estensione
	    $custom_extensions = array(
	        'username'         => $patient->user->getUsername(),
	        'password'         => $patient->user->getPassword(),
	        'codicefiscale'    => $patient->getFiscalCode(),
	        'stato'            => $patient->user->getStatus(),
	        'scadenza'         => $patient->user->getExpireDate(),
	        'email'            => $patient->user->getEmail()
	    );
	    
	    $data_xml["narrative"]     = $values_in_narrative;
	    $data_xml["extensions"]    = $custom_extensions;
	    $data_xml["patient"]       = $patient;
	    $data_xml["careproviders"] = $careproviders;
	    $data_xml["contacts"]      = $contacts;

        return view("fhir.patient", ["data_output" => $data_xml]);
	}
	
	function destroy($id_patient) {

	    $patient = Pazienti::find($id_patient);

	    //Verifico l'esistenza del paziente
	    if (!$patient) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        $patient->delete();
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

        $user->setIDTipology(User::PATIENT_ID);
        $user->setUsername($datafrom_name);
        $user->setPassword($datafrom_pass);
        $user->setStatus(1);
        $user->setEmail($datafrom_email);

        $user->save();
        
        $patient = new Pazienti();
        $patient->setID($user->getID());
        $patient->setName($doc->name->given["value"]);
        $patient->setSurname($doc->name->family["value"]);
        $patient->setBirth($doc->birthDate["value"]);
        $patient->setSex($doc->gender["value"]);
        $patient->setFiscalCode($doc->extension[1]->extension[3]->valueString["value"]);

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

        $patient_data->setName($doc->name->given["value"]);
        $patient_data->setSurname($doc->name->family["value"]);
        $patient_data->setBirth($doc->birthDate["value"]);
        $patient_data->setSex($doc->gender["value"]);
        $patient_data->setFiscalCode($doc->extension[1]->extension[2]->valueString["value"]);

        $user = User::find($patient_data->id_utente)->first();
        
        $user->setIDTipology(User::PATIENT_ID);
        $user->setUsername($datafrom_name);
        $user->setPassword($datafrom_pass);
        $user->setStatus(1);
        $user->setEmail($datafrom_email);
        
        $user->save();
        $patient_data->save();
	}
}
?>
