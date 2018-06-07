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
		
		$vaccini = Vaccini::where ( 'id_vaccinazione', $vaccinazione->getID () )->get();
		$pazienti = Pazienti::where ( 'id_paziente', $vaccinazione->getIDPaz () )->get();
		$careprovider = CareProvider::where ( 'id_cpp', $vaccinazione->getIDCpp () )->get();
		$reactions = VaccinazioniReaction::where ( 'id_vaccinazione', $vaccinazione->getID () )->get();
		
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
		$data_xml ["reactions"] = $reactions;
		
		return view ( "fhir.immunization", [ 
				"data_output" => $data_xml 
		] );
	}
	public function store(Request $request) {
		$doc = new \SimpleXMLElement ( $request->getContent () );
		
		$vaccinazione = Vaccinazione::find ( $doc->id ["value"] );
		$vaccinazione_id = $doc->id ["value"];
		$vaccinazione_status = $doc->status ["value"];
		$vaccinazione_notGiven = $doc->notGiven ["value"];
		$vaccinazione_Pazienteid = $doc->patient->reference ["value"];
		$vaccinazione_Date = $doc->date ["value"];
		$vaccinazione_Quantity = $doc->doseQuantity->value ["value"];
		$vaccinazione_Cpp = $doc->practitioner->actor->reference ["value"];
		$vaccinazione_Note = $doc->note->text ["value"];
		$vaccinazioneReactionData = array ();
		$vaccinazioneReactionIDCentro = array ();
		$vaccinazioneReactionReported = array ();
		foreach ( $doc->reaction as $rec ) {
			array_push ( $vaccinazioneReactionData, $rec->date ["value"] );
			array_push ( $vaccinazioneReactionIDCentro, substr ( $rec->detail->reference ["value"], 12 ) );
			array_push ( $vaccinazioneReactionReported, $rec->reported ["value"] );
		}
		$vaccinazione_Aggiornamento = $doc->extension->valueString ["value"];
		
		// Verifico l'integrità dei dati
		
		if ($vaccinazione) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided exists in database !" );
		}
		
		if (empty ( $vaccinazione_status )) {
			throw new FHIR\InvalidResourceFieldException ( "Status cannot be empty !" );
		}
		
		if (empty ( $vaccinazione_Pazienteid )) {
			throw new FHIR\InvalidResourceFieldException ( "IdPaziente cannot be empty !" );
		}
		
		if (empty ( $vaccinazione_Date )) {
			throw new FHIR\InvalidResourceFieldException ( "Data cannot be empty !" );
		}
		
		if (empty ( $vaccinazione_Quantity )) {
			throw new FHIR\InvalidResourceFieldException ( "Quantity cannot be empty !" );
		}
		
		if (empty ( $vaccinazione_Cpp )) {
			throw new FHIR\InvalidResourceFieldException ( "Practitioner cannot be empty !" );
		}
		
		/**
		 * VALIDAZIONE ANDATA A BUON FINE *
		 */
		
		$vacc = new Vaccinazione ();
		
		$vacc->setStatus ( $vaccinazione_status );
		$vacc->setNotGiven ( true );
		$vacc->setIDPaz ( substr ( $vaccinazione_Pazienteid, 8 ) );
		$vacc->setData ( $vaccinazione_Date );
		$vacc->setAggiornamento ( $vaccinazione_Aggiornamento );
		$vacc->setQuantity ( $vaccinazione_Quantity );
		$vacc->setIDCpp ( substr ( $vaccinazione_Cpp, 13 ) );
		$vacc->setVaccConf ( '4' );
		if (! empty ( $vaccinazione_Note )) {
			$vacc->setNote ( $vaccinazione_Note );
		}
		$vacc->save ();
		
		// Creo le Reazioni
		for($i = 0; $i < count ( $vaccinazioneReactionData ); $i ++) {
			
			$VR = new VaccinazioniReaction ();
			
			$VR->setIDCentro ( $vaccinazioneReactionIDCentro [$i] );
			$VR->setDate ( $vaccinazioneReactionData [$i] );
			$VR->setReport ( true );
			$VR->setIDVaccinazione ( $vaccinazione_id );
		}
		
		$VR->save ();
		
		return response ( '', 201 );
	}
	public function update(Request $request, $id) {
		$doc = new \SimpleXMLElement ( $request->getContent () );
		
		$vaccinazione = Vaccinazione::find ( $doc->id ["value"] )->first ();
		$vaccinazione_id = $doc->id ["value"];
		$vaccinazione_status = $doc->status ["value"];
		$vaccinazione_notGiven = $doc->notGiven ["value"];
		$vaccinazione_Pazienteid = $doc->patient->reference ["value"];
		$vaccinazione_Date = $doc->date ["value"];
		$vaccinazione_Quantity = $doc->doseQuantity->value ["value"];
		$vaccinazione_Cpp = $doc->practitioner->actor->reference ["value"];
		$vaccinazione_Note = $doc->note->text ["value"];
		$vaccinazioneReactionData = array ();
		$vaccinazioneReactionIDCentro = array ();
		$vaccinazioneReactionReported = array ();
		foreach ( $doc->reaction as $rec ) {
			array_push ( $vaccinazioneReactionData, $rec->date ["value"] );
			array_push ( $vaccinazioneReactionIDCentro, substr ( $rec->detail->reference ["value"], 12 ) );
			array_push ( $vaccinazioneReactionReported, $rec->reported ["value"] );
		}
		$vaccinazione_Aggiornamento = $doc->extension->valueString ["value"];
		
		// Verifico l'integrità dei dati
		
		if ($vaccinazione) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided exists in database !" );
		}
		
		if (empty ( $vaccinazione_status )) {
			throw new FHIR\InvalidResourceFieldException ( "Status cannot be empty !" );
		}
		
		if (empty ( $vaccinazione_Pazienteid )) {
			throw new FHIR\InvalidResourceFieldException ( "IdPaziente cannot be empty !" );
		}
		
		if (empty ( $vaccinazione_Date )) {
			throw new FHIR\InvalidResourceFieldException ( "Data cannot be empty !" );
		}
		
		if (empty ( $vaccinazione_Quantity )) {
			throw new FHIR\InvalidResourceFieldException ( "Quantity cannot be empty !" );
		}
		
		if (empty ( $vaccinazione_Cpp )) {
			throw new FHIR\InvalidResourceFieldException ( "Practitioner cannot be empty !" );
		}
		
		/**
		 * VALIDAZIONE ANDATA A BUON FINE *
		 */
		
		$vaccinazione->setStatus ( $vaccinazione_status );
		$vaccinazione->setNotGiven ( true );
		$vaccinazione->setIDPaz ( substr ( $vaccinazione_Pazienteid, 8 ) );
		$vaccinazione->setData ( $vaccinazione_Date );
		$vaccinazione->setAggiornamento ( $vaccinazione_Aggiornamento );
		$vaccinazione->setQuantity ( $vaccinazione_Quantity );
		$vaccinazione->setIDCpp ( substr ( $vaccinazione_Cpp, 13 ) );
		$vaccinazione->setVaccConf ( '4' );
		if (! empty ( $vaccinazione_Note )) {
			$vaccinazione->setNote ( $vaccinazione_Note );
		}
		$vaccinazione->save ();
		
	}
}
