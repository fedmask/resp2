<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Patient\PazientiVisite;
use App\Model\Patient\Pazienti;

class FHIRVisite extends Controller {
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}
	
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
	public function show($id_visita) {
		$data_Visita = PazientiVisite::find ( $id_visita );
		
		// Check the existance
		if (! $data_Visita->exists ()) {
			
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided doesn't exist in database" );
		}
		
		$careproviders = CppPaziente::where('id_paziente', $data_Visita->getID_Paziente())->get();
		$patient = Pazienti::where('id_utente', $data_Visita->getID_CareProvider())->get();
		
		$values_in_narrative = array (
				"PazienteNome" => $patient ->getNameFullName(),
				"CppNome"=> $careproviders->getCpp_FullName(),
				"Data" => $data_Visita->getData (),
				"Motivazione" => $data_Visita->getMotivazione (),
				"Osservazione" => $data_Visita->getOsservazione (),
				"Conclusione" => $data_Visita->getConclusione ()
		);
		
		$data_xml ["narrative"] = $values_in_narrative;
		$data_xml ["Visita"] = $data_Visita;
		$data_xml ["paziente"] = $patient;
		$data_xml ["careproviders"] = $careproviders;
		
		//@TODO Implementare vista
		return view ( "fhir.appointment", [ 
				"data_output" => $data_xml 
		] );
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
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
	public function destroy($id) {
		$Visita = PazientiVisite::find ( $id );
		
		if (! $Visita) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided doesn't exist in database" );
		}
		
		$Visita->delete ();
		//
	}
}
