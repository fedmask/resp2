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
		//
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
		//
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
		
		// Lancio dell'eccezione per verificare che la vaccinazione sia prensente nel sistema
		if (! $AnamnesiFamiliare->exists ()) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided doesn't exist in database" );
		}
		
		$AnamnesiFamiliare->delete ();
	}
}
