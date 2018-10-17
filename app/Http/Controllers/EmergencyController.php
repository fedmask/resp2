<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient\Pazienti;

class EmergencyController extends Controller
{
    /**
	* Mostra la pagina contenente la casella di ricerca Pazienti
	* alll' Emergency attualmente loggato.
	*/
	public function showPatientSearch(){
		$patients = Pazienti::All();
        return view('pages.emergency.patientSearch')->with('patients', $patients);
	}
}
