<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Input;

class ConsensiPazienteController extends Controller {
	//
	public function index() {
		$data ['listaTrattamenti'] = \App\TrattamentiPaziente::all ();
		return view ( 'pages.Consensi', $data );
	}
	public function create() {
		return view ( 'pages.Consensi' );
	}
	public function store(Request $request) {
	}
	public function show($id) {
		$data ['listaTrattamenti'] = \App\TrattamentiPaziente::where ( 'Id_Trattamento', $id )->first ();
		return view ( 'pages.Consensi', $data );
	}
	public function edit($id) {
	}
	public function update(Request $request, $id) {
		//$trattamenti_count = DB::table ( 'Trattamenti_Pazienti' )->count ();
		
		//Ottengo tutti i trattamenti per i Pazienti
		$trattamenti_list = TrattamentiPaziente::all();
		//Ciclo sui trattamenti
		foreach ( $trattamenti_list as $trattamento ) {
			//Trovo l'istanza della tabella Consenso_Paziente relazionate sia con il paziente che con il Trattamento 
			$trattamento_check = DB::table ( 'Consenso_Paziente' )->where ( 'Id_Trattamento', '=', $trattamento->Id_Trattamento )->
			where ( 'Id_Paziente', '=', '$id' )->get ()->Id_Consenso_P;
			
			
			$consenso = \app\Models\ConsensoPaziente::find($trattamento_check);
			
			if(($date = $request::get("check".($trattamento->Id_Trattamento)))==1){
				
				$consenso->Consenso = true;
				$consenso->data_consenso= now();
				$consenso->save();
			}
			
			return redirect('consenso')->with('ok_message', 'Tutto aggiornato correttamente');
		}
	}
	public function destroy($id) {
	}
}
