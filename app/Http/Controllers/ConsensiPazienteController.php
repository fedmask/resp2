<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Input;
use Carbon\Carbon;

// use Illuminate\Support\Facades\Input;
class ConsensiPazienteController extends Controller {
	//
	public function index() {
		$user_type = \App\Models\CurrentUser\User::find ( Auth::id () )->id_tipologia;
		$data = array ();
		
		switch ($user_type) {
			
			case 'ass' :
				$data ['listaTrattamenti'] = \App\TrattamentiPaziente::all ();
				
				$PazienteAuth = \App\Models\Patient\Pazienti::where ( 'id_utente', Auth::id () )->first ()->id_paziente;
				$this->createPazienteConsent ( $PazienteAuth );
				$data ['listaConsensi'] = \App\ConsensoPaziente::where ( 'Id_Paziente', $PazienteAuth )->get ();
				
				break;
			case 'mos' :
				$data ['listaTrattamenti'] = \App\TrattamentiCareProvider::all ();
				$CareProviderAuth = \App\Models\CareProviders\CareProvider::where ( 'id_utente', Auth::id () )->first ()->id_cpp;
				$this->createCareProviderConsent( $CareProviderAuth);
				$data ['listaConsensi'] = \App\ConsensoCareProvider::where ( 'Id_Cpp', $CareProviderAuth)->get ();
				break;
		}
		
		return view ( 'pages.Consensi', $data );
	}
	public function createCareProviderConsent($CareProviderAuth) {
		$listaTrattamenti = \App\TrattamentiCareProvider::all ();
		$CppCheck = \App\ConsensoCareProvider::where ( 'id_Cpp', $CareProviderAuth);
		
		
			
			foreach ( $listaTrattamenti as $TR ) {
				
				\App\ConsensoCareProvider::firstOrcreate ( [ 
						'Id_Trattamento' => $TR->Id_Trattamento],
						['Id_Cpp' => $CareProviderAuth,
						'Consenso' => false,
						'data_consenso' => now () 
				] )->save ();
			}
		
	}
	public function createPazienteConsent($PazienteAuth) {
		$listaTrattamenti = \App\TrattamentiPaziente::all ();
		$PazienteCheck = \App\ConsensoPaziente::where ( 'id_Paziente', $PazienteAuth);
		
	
			
			foreach ( $listaTrattamenti as $TR ) {
				
				\App\ConsensoPaziente::firstOrcreate ( [ 
						'Id_Trattamento' => $TR->Id_Trattamento],
						['Id_Paziente' => $PazienteAuth,
						'Consenso' => false,
						'data_consenso' => now () 
				] )->save ();
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
	
	public function updateCP(Request $request){
		
		$trattamenti_list = \App\TrattamentiCareProvider::all ();
		$CppAuth = \App\Models\CareProviders\CareProvider::where ( 'id_utente', Auth::id () )->first ()->id_cpp;
		// Ciclo sui trattamenti
		foreach ( $trattamenti_list as $trattamento ) {
			
			$consenso = (\App\ConsensoCareProvider::where ( 'Id_Trattamento', $trattamento->Id_Trattamento ))->where ( 'Id_Cpp', $CppAuth )->first ();
			
			if ((Input::get ( 'check' . $consenso->getID_Trattamento () )) === 'acconsento') {
				
				$consenso->Consenso = true;
				$consenso->data_consenso = now ();
				$consenso->save ();
			} else {
				$consenso->Consenso = false;
				$consenso->data_consenso = now ();
				$consenso->save ();
			}
			// $consenso->refresh();
		}
		
	}
	
	
	public function update(Request $request){
		
		$user_type = \App\Models\CurrentUser\User::find ( Auth::id () )->id_tipologia;
		
		switch ($user_type) {
			
			case 'ass' :
				$this->updatePaziente($request);
				break;
				
			case 'mos' :
				
				$this->updateCP($request);
				break;
		}
		return redirect ( '/consent' )->with ( 'ok_message', 'Tutto aggiornato correttamente' );
	}
	
	
	public function updatePaziente(Request $request) {
		// $trattamenti_count = DB::table ( 'Trattamenti_Pazienti' )->count ();
		
		// Ottengo tutti i trattamenti per i Pazienti
		$trattamenti_list = \App\TrattamentiPaziente::all ();
		$PazienteAuth = \App\Models\Patient\Pazienti::where ( 'id_utente', Auth::id () )->first ()->id_paziente;
		// Ciclo sui trattamenti
		foreach ( $trattamenti_list as $trattamento ) {
			
			$consenso = (\App\ConsensoPaziente::where ( 'Id_Trattamento', $trattamento->Id_Trattamento ))->where ( 'Id_Paziente', $PazienteAuth )->first ();
			
			if ((Input::get ( 'check' . $consenso->getID_Trattamento () )) === 'acconsento') {
				
				$consenso->Consenso = true;
				$consenso->data_consenso = now ();
				$consenso->save ();
			} else {
				$consenso->Consenso = false;
				$consenso->data_consenso = now ();
				$consenso->save ();
			}
			// $consenso->refresh();
		}
		
	}
	public function destroy($id) {
	}
}
