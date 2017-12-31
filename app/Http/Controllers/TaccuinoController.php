<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient\Pazienti;
use App\Models\CurrentUser\User;
use App\Models\CurrentUser\Recapiti;
use App\Models\Domicile\Comuni;
use App\Models\Patient\Taccuino;
use Validator;
use Redirect;
use Auth;
use DB;
use Input;

class TaccuinoController extends Controller
{
	/**
	* Aggiunge una nuova segnalazione all'interno
	* del taccuino del paziente
	*/
	public function addReporting(Request $request){
		$descrizione = Input::get('save_pain_textarea'); //$request->input('description');
		$front = Input::get('front');
		$back = Input::get('back');
		$data = Input::get('datanota');
		if($descrizione == ""){
			$descrizione = "Nessun commento.";
		}
		$taccuino = Taccuino::create([
            'id_paziente' => Pazienti::where('id_utente', Auth::id())->first()->id_paziente,
            'taccuino_descrizione' => $descrizione,
            'taccuino_data' => $data,
            'taccuino_report_anteriore' => $front,
            'taccuino_report_posteriore' => $back,
        ]);

        $taccuino->save();
		return Redirect::back()->with("Success");
	}

	/**
	* Rimuove un valore tra i record del Taccuino
	*/
	public function removeReporting(){
		$reporting = Taccuino::find(Input::get('id_taccuino'));
		$reporting->delete();
		return Redirect::back()->with('reporting_deleted');
	}
}
