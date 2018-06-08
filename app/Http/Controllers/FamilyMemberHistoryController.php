<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\History\AnamnesiFamiliare as AnamnesiFamiliare;
use App\Models\Parente;
use App\Models\FamilyCondition;
use App\Models\AnamnesiF;

class FamilyMemberHistoryController extends Controller {
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		
	    $doc = new \SimpleXMLElement ( $request->getContent () );
	    
	    $anamnesiF = AnamnesiF::find ( $doc->id ["value"] );
	    $anamnesi = $doc->id ["value"];
	    $anamnesi_id = $doc->identifier->value ["value"];
	    $anamnesi_status = $doc->status->value ["value"];
	    $anamnesi_notDone = $doc->notDone->value ["value"];
	    $patient_id = $doc->patient->reference->value ["value"];
	    $patient_name = $doc->patient->display->value ["value"];
	    $patient_relation = $doc->relationship[0]->reference->value ["value"];
	    $anamnesi_data = $doc->data->value ["value"];
	    $relazione_codice = $doc->relationship[1]->coding->code->value ["value"];
	    $relazione_desc = $doc->relationship[1]->coding->display->value ["value"];
	    $parent_gender = $doc->gender->value ["value"];
	    
	    $parent_eta = $doc->age->Age->value ["value"];
	    $parent_born = $doc->born->date->value ["value"];
	    
	    $codiction_id = array ();
	    $codiction_desc = array ();
	    $codiction_age = array ();
	    $codiction_note = array ();
	    
	    foreach ( $doc->condiction as $cond ) {
	        array_push ( $codiction_id, $cond->code->coding->code->value ["value"] );
	        array_push ( $codiction_desc, $cond->code->coding->display->value ["value"] );
	        array_push ( $codiction_age, $cond->onsetAge->value->value ["value"] );
	        array_push ( $vaccinazioneReactionReported, $cond->>note->text->value ["value"] );
	    }
	    
	    // Verifico l'integrità dei dati
	    if ($anamnesiF) {
	        throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided exists in database !" );
	    }
	    
	    if (empty ( $anamnesi_status)) {
	        throw new FHIR\InvalidResourceFieldException ( "Status cannot be empty !" );
	    }
	    
	    if (empty ( $patient_id )) {
	        throw new FHIR\InvalidResourceFieldException ( "Patient code cannot be empty !" );
	    }
	    
	    if (empty ( $patient_name )) {
	        throw new FHIR\InvalidResourceFieldException ( "Patient name  cannot be empty !" );
	    }
	    if (empty ( $patient_relation)) {
	        throw new FHIR\InvalidResourceFieldException ( "Relationship  cannot be empty !" );
	    }
	    if (empty ( $anamnesi_data)) {
	        throw new FHIR\InvalidResourceFieldException ( "Data cannot be empty !" );
	    }
	    
	    
	    if (empty ( $codiction_id)) {
	        throw new FHIR\InvalidResourceFieldException ( "Id Condiction  cannot be empty !" );
	    }
	    
	    if (empty ( $codiction_desc)) {
	        throw new FHIR\InvalidResourceFieldException ( "Descrizione condiction  cannot be empty !" );
	    }
	    
	    if (empty ( $codiction_age)) {
	        throw new FHIR\InvalidResourceFieldException ( "Age condiction  cannot be empty !" );
	    }
	    
	    
	    /**
	     * VALIDAZIONE ANDATA A BUON FINE *
	     */
	    
	    $anamn = new AnamnesiF();
	    
	    $anamn->setStatus($anamnesi_status);
	    $anamn->setIDPaziente($patient_id);
	    $anamn->setCodice($patient_relation);
	    $anamn->setNDR($anamnesi_notDone);
	    $anamn->setCodice(relazione_codice);
	    $anamn->setCDescrizione($relazione_desc);
	    $anamn->setData($anamnesi_data);
	    $anamn->save ();
	    
	    
	    for($i = 0; $i < count ( $vaccinazioneReactionData ); $i ++) {
	        
	        $cond = new FamilyCondition();
	        
	        $cond->setID(codiction_id);
	        $cond->setoutCome($codiction_desc);
	        $cond->setAgeValue($codiction_age);
	        $cond->setNote($codiction_note);
	    }
	    $cond->save ();
	    
	    return response ( '', 201 );
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		/**
		 * L'anamnesi famigliare viene utilizzata come identiicatore e viene a sua volta utilizzata per acqisire
		 * le informazioni relative ai parenti, alle loro patologie e alla relazione tra quest'ultimi e il paziente
		 */
		
		// Si utilizza il modello AnamnesiF solo per ottenere l'identificativo del parente associato al paziente
		$AnamnesiF = AnamnesiF::where ( 'id_anamnesiF', $id )->first ();
		
		if (! $AnamnesiF) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided doesn't exist in database" );
		}
		
		/**
		 * Ottengo le istanze della relazione AnamnesiFamiliare
		 *
		 * @var unknown $AnamnesiFamiliare
		 */
		$AnamnesiFamiliare = AnamnesiFamiliare::where ( 'id_paziente', $AnamnesiF->getIDPaziente () )->get ();
		
		/**
		 * Ottengo il paziente
		 *
		 * @var unknown $Paziente
		 */
		
		$Paziente = Pazienti::where ( 'id_paziente', $AnamnesiFamiliare->getID () )->get ();
		/**
		 * Ottengo i Parenti
		 *
		 * @var unknown $Parenti
		 */
		$Parente = Parente::where ( 'id_parente', $AnamnesiF->getIDCpp () )->get ();
		
		/**
		 * Ottengo le relazioni relative alle diagnosi del parente
		 *
		 * @var unknown $FamilyCondition
		 */
		$FamilyCondition = FamilyCondition::where ( 'id_parente', $Parente->getID () )->get ();
		
		/**
		 * Non sono stati utilizzate le values_in_narrative per via della grande sparsità dei dati
		 */
		
		/*
		 * Rimpiazzata con un metodo in Family Condition
		 */
		// $ICD9 = ICD9_ICPT::where ( 'Codice_ICD9', $FamilyCondition->getICD9 () )->get ();
		
		$data_xml ["Paziente"] = $Paziente;
		$data_xml ["AnamnesiF"] = $AnamnesiF;
		$data_xml ["Parenti"] = $Parente;
		$data_xml ["Condition"] = $FamilyCondition;
		
		return view ( "fhir.FamilyMemberHistory", [ 
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
	    $doc = new \SimpleXMLElement ( $request->getContent () );
	    
	    $anamnesiF = AnamnesiF::find ( $doc->id ["value"] );
	    $anamnesi = $doc->id ["value"];
	    $anamnesi_id = $doc->identifier->value ["value"];
	    $anamnesi_status = $doc->status->value ["value"];
	    $anamnesi_notDone = $doc->notDone->value ["value"];
	    $patient_id = $doc->patient->reference->value ["value"];
	    $patient_name = $doc->patient->display->value ["value"];
	    $patient_relation = $doc->relationship[0]->reference->value ["value"];
	    $anamnesi_data = $doc->data->value ["value"];
	    $relazione_codice = $doc->relationship[1]->coding->code->value ["value"];
	    $relazione_desc = $doc->relationship[1]->coding->display->value ["value"];
	    $parent_gender = $doc->gender->value ["value"];
	    
	    $parent_eta = $doc->age->Age->value ["value"];
	    $parent_born = $doc->born->date->value ["value"];
	    
	    $codiction_id = array ();
	    $codiction_desc = array ();
	    $codiction_age = array ();
	    $codiction_note = array ();
	    
	    foreach ( $doc->condiction as $cond ) {
	        array_push ( $codiction_id, $cond->code->coding->code->value ["value"] );
	        array_push ( $codiction_desc, $cond->code->coding->display->value ["value"] );
	        array_push ( $codiction_age, $cond->onsetAge->value->value ["value"] );
	        array_push ( $vaccinazioneReactionReported, $cond->>note->text->value ["value"] );
	    }
	    
	    // Verifico l'integrità dei dati
	    if ($anamnesiF) {
	        throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided exists in database !" );
	    }
	    
	    if (empty ( $anamnesi_status)) {
	        throw new FHIR\InvalidResourceFieldException ( "Status cannot be empty !" );
	    }
	    
	    if (empty ( $patient_id )) {
	        throw new FHIR\InvalidResourceFieldException ( "Patient code cannot be empty !" );
	    }
	    
	    if (empty ( $patient_name )) {
	        throw new FHIR\InvalidResourceFieldException ( "Patient name  cannot be empty !" );
	    }
	    if (empty ( $patient_relation)) {
	        throw new FHIR\InvalidResourceFieldException ( "Relationship  cannot be empty !" );
	    }
	    if (empty ( $anamnesi_data)) {
	        throw new FHIR\InvalidResourceFieldException ( "Data cannot be empty !" );
	    }
	    
	    
	    if (empty ( $codiction_id)) {
	        throw new FHIR\InvalidResourceFieldException ( "Id Condiction  cannot be empty !" );
	    }
	    
	    if (empty ( $codiction_desc)) {
	        throw new FHIR\InvalidResourceFieldException ( "Descrizione condiction  cannot be empty !" );
	    }
	    
	    if (empty ( $codiction_age)) {
	        throw new FHIR\InvalidResourceFieldException ( "Age condiction  cannot be empty !" );
	    }
	    
	    
	    /**
	     * VALIDAZIONE ANDATA A BUON FINE *
	     */
	    
	    $anamn = new AnamnesiF();
	    
	    $anamn->setStatus($anamnesi_status);
	    $anamn->setIDPaziente($patient_id);
	    $anamn->setCodice($patient_relation);
	    $anamn->setNDR($anamnesi_notDone);
	    $anamn->setCodice(relazione_codice);
	    $anamn->setCDescrizione($relazione_desc);
	    $anamn->setData($anamnesi_data);
	    $anamn->save ();
	    
	    
	    for($i = 0; $i < count ( $vaccinazioneReactionData ); $i ++) {
	        
	        $cond = new FamilyCondition();
	        
	        $cond->setID(codiction_id);
	        $cond->setoutCome($codiction_desc);
	        $cond->setAgeValue($codiction_age);
	        $cond->setNote($codiction_note);
	    }
	    $cond->save ();
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id_paziente) {
		//
		$AnamnesiFamiliare = AnamnesiFamiliare::find ( $id_paziente );
		
		// Lancio dell'eccezione per verificare che l' anamnesi sia prensente nel sistema
		if (! $AnamnesiFamiliare->exists ()) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided doesn't exist in database" );
		}
		
		$AnamnesiFamiliare->delete ();
	}
}
