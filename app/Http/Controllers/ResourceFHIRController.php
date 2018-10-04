<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Models\Patient\Pazienti;
use App\Models\CareProviders\CareProvider;


class ResourceFHIRController extends Controller {
	
	public function indexPatient(){
	    
	    $patients = Pazienti::all();
	    

	    return view("pages.fhir.resourcePatient", [
	        "data_output" => $patients
	    ]);
	}
	
	
	public function indexPractictioner(){
	    
	    $practictioner = CareProvider::all();
	    
	    
	    return view("pages.fhir.resourcePractictioner", [
	        "data_output" => $practictioner
	    ]);
	}
	
	
}
?>
