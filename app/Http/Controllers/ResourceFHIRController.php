<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Models\Patient\Pazienti;


class ResourceFHIRController extends Controller {
	
	public function index(){
	    
	    $patients = Pazienti::all();
	    

	    return view("pages.fhir.resourcePatient", [
	        "data_output" => $patients
	    ]);
	}
}
?>
