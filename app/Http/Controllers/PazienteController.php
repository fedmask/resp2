<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pazienti;
use Auth;
use Input;

class PazienteController extends Controller
{
    public function updateOrgansDonor (Request $request){
		$paziente = Pazienti::findByIdUser(Auth::id());
		if(Input::get('patdonorg') === 'acconsento'){
			$paziente->paziente_donatore_organi = 1;
		} else {
			$paziente->paziente_donatore_organi = 0;
		}
		$paziente->save();
		return redirect( '/patient-summary' );
	}
}
