<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vaccine\Vaccinazione as Vaccinazione;

class FHIRImmunizationController extends Controller {
	//
	/* Implementazione del Servizio REST: DELETE */
	public function destroy($id_vaccinazione) {
		$vaccinazione = Vaccinazione::find ( $id_vaccinazione );
		
		// Lancio dell'eccezione per verificare che la vaccinazione sia prensente nel sistema
		if (! $vaccinazione->exists ()) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided doesn't exist in database" );
		}
		
		$vaccinazione->delete ();
	}
	
	/* Implementazione del Servizio REST: GET */
	public function show($id) {
		$vaccinazione = Vaccinazione::where ( 'id_vaccinazione', $id )->first ();
		if (! $vaccinazione) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided doesn't exist in database" );
		}
		
		$values_in_narrative = array (
				
				"Vaccinacione Conf"=>$vaccinazione-get			
				
		);
		
		// Recupero i contatti di emergenza del paziente
		$contacts = PazientiContatti::where ( 'id_paziente', $id )->get ();
		
		// Recupero gli operatori sanitari del paziente
		$careproviders = CppPaziente::where ( 'id_paziente', $id )->get ();
		
		// Sono i valori che verranno riportati nella parte descrittiva del documento
		// Indicare CHIAVE e VALORE di ogni riga (es: Nome => "Antonio Rossi")
		$values_in_narrative = array (
				"Name" => $patient->getFullName (),
				"BirthDate" => $patient->getBirth (),
				"Contact" => $patient->getPhone (),
				"City" => $patient->getCity (),
				"Address" => $patient->getLine (),
				"State" => "Italia IT", // Al momento è un vincolo RESP
				"Marital Status" => $patient->getStatusWedding () 
		);
		
		// prelevo i dati dell'utente da mostrare come estensione
		$custom_extensions = array (
				'username' => $patient->user->getUsername (),
				'password' => $patient->user->getPassword (),
				'codicefiscale' => $patient->getFiscalCode (),
				'stato' => $patient->user->getStatus (),
				'scadenza' => $patient->user->getExpireDate (),
				'email' => $patient->user->getEmail () 
		);
		
		$data_xml ["narrative"] = $values_in_narrative;
		$data_xml ["extensions"] = $custom_extensions;
		$data_xml ["patient"] = $patient;
		$data_xml ["careproviders"] = $careproviders;
		$data_xml ["contacts"] = $contacts;
		
		return view ( "fhir.patient", [ 
				"data_output" => $data_xml 
		] );
	}
}
