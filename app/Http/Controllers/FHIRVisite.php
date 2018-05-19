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
		$Visita = PazientiVisite::where ( 'id_visita', $id_visita )->first;
		
		if (! $Visita) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided doesn't exist in database" );
		}
		
		// Recupero informazioni delle Visite
		
		$patient = Pazienti::where ( 'id_utente', $id )->get ();
		$careproviders = CppPaziente::where ( 'id_paziente', $id )->get ();
		
		// @todo Completare recuperando le informazioni relative alla Patologia non ancora esistente
		
		$values_in_narrative = array (
				
				"Data" =>$Visita->get
				
				"Name" => $patient->getFullName (),
				"BirthDate" => $patient->getBirth (),
				"Contact" => $patient->getPhone (),
				"City" => $patient->getCity (),
				"Address" => $patient->getLine (),
				"State" => "Italia IT", // Al momento è un vincolo RESP
				"Marital Status" => $patient->getStatusWedding () 
		);
		
		/*
		 * $patient = Pazienti::where('id_utente', $id)->first();
		 *
		 * if (!$patient) {
		 * throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
		 * }
		 *
		 * //Recupero i contatti di emergenza del paziente
		 * $contacts = PazientiContatti::where('id_paziente', $id)->get();
		 *
		 * //Recupero gli operatori sanitari del paziente
		 * $careproviders = CppPaziente::where('id_paziente', $id)->get();
		 *
		 * //Sono i valori che verranno riportati nella parte descrittiva del documento
		 * //Indicare CHIAVE e VALORE di ogni riga (es: Nome => "Antonio Rossi")
		 * $values_in_narrative = array(
		 * "Name" => $patient->getFullName(),
		 * "BirthDate" => $patient->getBirth(),
		 * "Contact" => $patient->getPhone(),
		 * "City" => $patient->getCity(),
		 * "Address" => $patient->getLine(),
		 * "State" => "Italia IT", //Al momento è un vincolo RESP
		 * "Marital Status" => $patient->getStatusWedding()
		 * );
		 *
		 * // prelevo i dati dell'utente da mostrare come estensione
		 * $custom_extensions = array(
		 * 'username' => $patient->user->getUsername(),
		 * 'password' => $patient->user->getPassword(),
		 * 'codicefiscale' => $patient->getFiscalCode(),
		 * 'stato' => $patient->user->getStatus(),
		 * 'scadenza' => $patient->user->getExpireDate(),
		 * 'email' => $patient->user->getEmail()
		 * );
		 *
		 * $data_xml["narrative"] = $values_in_narrative;
		 * $data_xml["extensions"] = $custom_extensions;
		 * $data_xml["patient"] = $patient;
		 * $data_xml["careproviders"] = $careproviders;
		 * $data_xml["contacts"] = $contacts;
		 *
		 * return view("fhir.patient", ["data_output" => $data_xml]);
		 */
		//
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
