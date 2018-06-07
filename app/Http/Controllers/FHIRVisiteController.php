<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Patient\PazientiVisite;
use App\Model\Patient\Pazienti;

class FHIRVisite extends Controller {
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$doc = new \SimpleXMLElement ( $request->getContent () );
		
		$visita = PazientiVisite::find ( $doc->id ["value"] );
		$visita_id = $doc->id ["value"];
		$visita_stato_visita = $doc->status->value ["value"];
		$visita_motivazione = $doc->reason->code->value ["value"];
		$visita_cod_priorità = $doc->priority->value ["value"];
		$visita_data = $doc->start->value ["value"];
		$visita_osservazioni = $doc->extension->valueString ["value"];
		$visita_conclusioni = $doc->comment->value ["value"];
		$paziente_id = substr ($doc->partecipant ->actor [0]->reference ->value ["value"],8);
		$paziente_fullname = $doc->partecipant ->actor [0]->display ->value ["value"];
		$visita_t_richiesta = $doc->partecipant ->required [0]->value ["value"];
		$visita_status = $doc->partecipant ->status [0]->value ["value"];
		$cpp_id = substr ($doc->partecipant ->actor [1]->reference->value ["value"],13);
		$cpp_fullname = $doc->partecipant ->actor [1]->display->value ["value"];
		$visita_Inizio = $doc->requestedPeriod ->start ->value ["value"];
		$visita_Fine = $doc->requestedPeriod ->end ->value ["value"];
		
		if ($visita_id) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided exists in database !" );
		}
		
		if (empty($visita_stato_visita)) {
			throw new FHIR\InvalidResourceFieldException( "Stato visita cannot be empty !" );
		}
		
		if (empty($visita_motivazione)) {
			throw new FHIR\InvalidResourceFieldException( "Motivazione cannot be empty !" );
		}
		
		if (empty($visita_cod_priorità)) {
			throw new FHIR\InvalidResourceFieldException( "Codice priorità cannot be empty !" );
		}
		
		if (empty($visita_data)) {
			throw new FHIR\InvalidResourceFieldException( "Visita data visita cannot be empty !" );
		}
		
		if (empty($paziente_id)) {
			throw new FHIR\InvalidResourceFieldException( "paziente id cannot be empty !" );
		}
		
		if (empty($visita_t_richiesta)) {
			throw new FHIR\InvalidResourceFieldException( "Tipo Richiesta cannot be empty !" );
		}
		
		if (empty($visita_status)) {
			throw new FHIR\InvalidResourceFieldException( "Status cannot be empty !" );
		}
		
		if (empty($cpp_id)) {
			throw new FHIR\InvalidResourceFieldException( "Cpp id cannot be empty !" );
		}
		
		/*VALIDAZIONE ANDATA A BUON FINE */
		
		$data_visita = new PazientiVisite ();
		
		$data_visita->setID ( $visita_id );
		$data_visita->setIdCpp ( $cpp_id );
		$data_visita->setIdPazienti ( $paziente_id );
		$data_visita->setVisitaData ( $visita_data );
		$data_visita->setVisitaMotivazione ( $visita_motivazione );
		$data_visita->setConclusioni ( $visita_conclusioni );
		$data_visita->setVisitaOsservazioni ( $visita_osservazioni );
		$data_visita->setStato ( $visita_stato_visita );
		$data_visita->setCodiceP ( $visita_cod_priorità );
		$data_visita->setTRichiesta ( $visita_t_richiesta );
		$data_visita->setStatus ( $visita_status );
		
		if ($visita_Inizio || $visita_Fine) {
			$data_visita->setRichiestaVI ( $visita_Inizio );
			$data_visita->setRichiestaVF ( $visita_Fine );
		}
		
		$data_visita->save ();
		
		return response ( '', 201 );
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function show($id_visita) {
		$data_Visita = PazientiVisite::find ( $id_visita );
		
		// Check the existance
		if (! $data_Visita->exists ()) {
			
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided doesn't exist in database" );
		}
		
		$careprovider = CareProvider::where ( 'id_cpp', $data_Visita->getID_CareProvider () )->get ();
		$patient = Pazienti::where ( 'id_utente', $data_Visita->getID_Paziente () )->get ();
		
		// Recupero record da tabella intermedia tra Specialization e Visita
		$visita_spec = VisitaSpecialization::where ( 'id_visita', $data_Visita->getID () )->get();
		// Recupero record da tabella Specialization
		$specialization = Specialization::where ( 'id_spec', $visita_spec->getIdSpec () )->get();
		
		/*
		 * $cpp_spec = CppSpecialization::where ( 'id_cpp', $careproviders->getID () );
		 * $SpecializationCpp = Specialization::where ( 'id_spec', $cpp_spec->getIdSpec () );
		 */
		
		$values_in_narrative = array (
				"PazienteNome" => $patient->getNameFullName (),
				"CppNome" => $careproviders->getCpp_FullName (),
				"Data" => $data_Visita->getData (),
				"Motivazione" => $data_Visita->getMotivazione (),
				"Osservazione" => $data_Visita->getOsservazione (),
				"Conclusione" => $data_Visita->getConclusione () 
		);
		
		// Si intende che per ogni visita esiste un solo care provider come da db
		$data_xml ["narrative"] = $values_in_narrative;
		$data_xml ["Visita"] = $data_Visita;
		$data_xml ["paziente"] = $patient;
		$data_xml ["careprovider"] = $careprovider;
		$data_xml ["specialization"] = $specialization;
		
		
		return view ( "fhir.appointment", [ 
				"data_output" => $data_xml 
		] );
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		
		//		
		$doc = new \SimpleXMLElement ( $request->getContent () );
		
		$visita = PazientiVisite::find ( $doc->id ["value"] );
		$visita_id = $doc->id ["value"];
		$visita_stato_visita = $doc->status->value ["value"];
		$visita_motivazione = $doc->reason->code->value ["value"];
		$visita_cod_priorità = $doc->priority->value ["value"];
		$visita_data = $doc->start->value ["value"];
		$visita_osservazioni = $doc->extension->valueString ["value"];
		$visita_conclusioni = $doc->comment->value ["value"];
		$paziente_id = substr ($doc->partecipant ->actor [0]->reference ->value ["value"],8);
		$paziente_fullname = $doc->partecipant ->actor [0]->display ->value ["value"];
		$visita_t_richiesta = $doc->partecipant ->required [0]->value ["value"];
		$visita_status = $doc->partecipant ->status [0]->value ["value"];
		$cpp_id = substr ($doc->partecipant ->actor [1]->reference->value ["value"],13);
		$cpp_fullname = $doc->partecipant ->actor [1]->display->value ["value"];
		$visita_Inizio = $doc->requestedPeriod ->start ->value ["value"];
		$visita_Fine = $doc->requestedPeriod ->end ->value ["value"];
		
		if ($visita_id) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided does not exists in database !" );
		}
		
		if (empty($visita_stato_visita)) {
			throw new FHIR\InvalidResourceFieldException( "Stato visita cannot be empty !" );
		}
		
		if (empty($visita_motivazione)) {
			throw new FHIR\InvalidResourceFieldException( "Motivazione cannot be empty !" );
		}
		
		if (empty($visita_cod_priorità)) {
			throw new FHIR\InvalidResourceFieldException( "Codice priorità cannot be empty !" );
		}
		
		if (empty($visita_data)) {
			throw new FHIR\InvalidResourceFieldException( "Visita data visita cannot be empty !" );
		}
		
		if (empty($paziente_id)) {
			throw new FHIR\InvalidResourceFieldException( "paziente id cannot be empty !" );
		}
		
		if (empty($visita_t_richiesta)) {
			throw new FHIR\InvalidResourceFieldException( "Tipo Richiesta cannot be empty !" );
		}
		
		if (empty($visita_status)) {
			throw new FHIR\InvalidResourceFieldException( "Status cannot be empty !" );
		}
		
		if (empty($cpp_id)) {
			throw new FHIR\InvalidResourceFieldException( "Cpp id cannot be empty !" );
		}
		
		
		$data_visita->setID ( $visita_id );
		$data_visita->setIdCpp ( $cpp_id );
		$data_visita->setIdPazienti ( $paziente_id );
		$data_visita->setVisitaData ( $visita_data );
		$data_visita->setVisitaMotivazione ( $visita_motivazione );
		$data_visita->setConclusioni ( $visita_conclusioni );
		$data_visita->setVisitaOsservazioni ( $visita_osservazioni );
		$data_visita->setStato ( $visita_stato_visita );
		$data_visita->setCodiceP ( $visita_cod_priorità );
		$data_visita->setTRichiesta ( $visita_t_richiesta );
		$data_visita->setStatus ( $visita_status );
		
		if ($visita_Inizio || $visita_Fine) {
			$data_visita->setRichiestaVI ( $visita_Inizio );
			$data_visita->setRichiestaVF ( $visita_Fine );
		}
		
		$data_visita->save ();
	
		
		
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$Visita = PazientiVisite::find ( $id );
		
		if (! $Visita) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided doesn't exist in database" );
		}
		
		$Visita->delete ();
		//
	}
}
