<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vaccine\Vaccinazione as Vaccinazione;
use App\Models\CareProviders\CareProvider as CareProvider;
use App\Models\Patient\Pazienti as Pazienti;
use App\Models\Vaccine\Vaccini as Vaccini;

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
		
		/*
		 * // Recupero i contatti di emergenza del paziente
		 * $contacts = PazientiContatti::where ( 'id_paziente', $id )->get ();
		 */
		
		$vaccini = Vaccini::where ( 'id_vaccinazione', $vaccinazione->getID() );
		$pazienti = Pazienti::where ( 'id_paziente', $vaccinazione->getIDPaz () );
		$careprovider = CareProvider::where ( 'id_cpp', $vaccinazione->getIDCpp () );
		$reactions = VaccinazioniReaction::where ( 'id_vaccinazione', $vaccinazione->getID () );
		
		$values_in_narrative = array (
				
				"Vaccinacione Conf" => $vaccinazione->getVaccConf (),
				"Vaccinazione Reazioni" => $vaccinazione->getReazioni (),
				"Vaccinazione Stato" => $vaccinazione->getStatus (),
				"Vaccinazione Quantity" => $vaccinazione->getQuantity (),
				"Vaccinazione Note" => $vaccinazione->getNote (),
				"Vaccinazione Explanation" => $vaccinazione->getExplanation (),
				"Vaccinazione Data" => $vaccinazione->getData () 
		
		);
		
		$custom_extensions = array (
				
				"Vaccinazione Aggiornamento" => $vaccinazione->getAggiornamento () 
		
		);
		
		$data_xml ["immunization"] = $vaccinazione;
		$data_xml ["narrative"] = $values_in_narrative;
		$data_xml ["extensions"] = $custom_extensions;
		$data_xml ["pazienti"] = $pazienti;
		$data_xml ["careprovider"] = $careprovider;
		$data_xml ["vaccini"] = $vaccini;
		$data_xml["reactions"]=$reactions;
		
		
		return view ( "fhir.immunization", [ 
				"data_output" => $data_xml 
		] );
	}
}
