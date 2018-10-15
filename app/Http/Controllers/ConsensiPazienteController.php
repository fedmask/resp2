<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Input;
use Carbon\Carbon;
//use Illuminate\Support\Facades\Input;

class ConsensiPazienteController extends Controller {
	//
	public function index() {
		$data ['listaTrattamenti'] = \App\TrattamentiPaziente::all ();
		
		$PazienteAuth = \App\Models\Patient\Pazienti :: where ( 'id_utente', Auth::id())->first()->id_paziente;
		$this->create($PazienteAuth);
		$data['listaConsensi'] =  \App\ConsensoPaziente::where ( 'Id_Paziente', $PazienteAuth)->get ();
		return view ( 'pages.Consensi', $data );
	}
	public function create($PazienteAuth) {
		$listaTrattamenti = \App\TrattamentiPaziente::all ();
		$PazienteCheck = \App\ConsensoPaziente:: where ( 'id_Paziente', Auth::id());
		
		if($PazienteCheck->count() == 0){
			
			foreach ($listaTrattamenti as $TR){
				
				\App\ConsensoPaziente::create([
						'Id_Trattamento' => $TR->Id_Trattamento,
						'Id_Paziente' => $PazienteAuth,
						'Consenso' => false,
						'data_consenso'=> now(),
				])->save();
				
				
			}
			
		}
		
	}
	public function store(Request $request) {
	}
	public function show($id) {
		$data ['listaTrattamenti'] = \App\TrattamentiPaziente::where ( 'Id_Trattamento', $id )->first ();
		return view ( 'pages.Consensi', $data );
	}
	public function edit($id) {
	}
	public function update(Request $request) {
		//$trattamenti_count = DB::table ( 'Trattamenti_Pazienti' )->count ();
		
		//Ottengo tutti i trattamenti per i Pazienti
		$trattamenti_list = \App\TrattamentiPaziente::all();
		$PazienteAuth = \App\Models\Patient\Pazienti :: where ( 'id_utente', Auth::id())->first()->id_paziente;
		//Ciclo sui trattamenti
		foreach ( $trattamenti_list as $trattamento ) {
			
			$consenso = (\App\ConsensoPaziente::where('Id_Trattamento',$trattamento->Id_Trattamento))->where('Id_Paziente',$PazienteAuth)->first();
	
			if((Input::get('check'.$consenso->getID_Trattamento()))==='acconsento'){
				
				$consenso->Consenso = true;
				$consenso->data_consenso= now();
				$consenso->save();
			}else{
				$consenso->Consenso = false;
				$consenso->data_consenso= now();
				$consenso->save();
			}
			//$consenso->refresh();
			
		}
		return redirect('/consent')->with('ok_message', 'Tutto aggiornato correttamente');
	}
	public function destroy($id) {
	}
}
