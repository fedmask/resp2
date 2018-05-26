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
		$data_ = CppPersona::find($id_cpp);
		
		//Verifico l'esistenza del care provider
		if (!$data_cpp->exists()) {
			throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
		}
		
		$values_in_narrative = array(
				"Name"       => $data_cpp->getName() . " " . $data_cpp->getSurname(),
				"Contact"    => $data_cpp->getPhone(),
				"City"       => $data_cpp->getTown()
		);
		
		$data_xml["narrative"]     = $values_in_narrative;
		$data_xml["careprovider"]  = $data_cpp;
		
		return view("fhir.practitioner", ["data_output" => $data_xml]);
		
		
		$data_Visita = PazientiVisite::find($id_visita);
		
		//Check the existance
		if(!$data_Visita->exists()){
			
			throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
	
		}
		
		$values_in_narrative = array(
				"Data"       => $data_Visita->getName() . " " . $data_cpp->getSurname(),
				"Motivazione"    => $data_Visita->getPhone(),
				"Osservazione"       => $data_Visita->getTown(),
				"Conclusione"       => $data_Visita->getTown()
		);
		
		
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
