<?php

namespace App\Http\Middleware\Trattamenti;

use Auth;
use Closure;
use Illuminate\Http\Response;

class RedirectifConsentChecked {
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param \Closure $next        	
	 * @return mixed
	 */
	public function handle($request, Closure $next, $trattamento) {
		$user_type = \App\Models\CurrentUser\User::find ( Auth::id () )->id_tipologia;
		
		switch ($user_type) {
			
			case 'mos' :
				
				$CareProviderAuth = \App\Models\CareProviders\CareProvider::where ( 'id_utente', Auth::id () )->first ()->id_cpp;
				$CppCheck = \App\ConsensoCareProvider::where ( 'id_Cpp', $CareProviderAuth );
				
				\App\Http\Controllers\ConsensiController::createCPConsent ($CareProviderAuth);
				if ($this->search ( $CppCheck, $trattamento)) {
					return $next ( $request );
				}
				break;
			
			case 'ass' :
				
				$PazienteAuth = \App\Models\Patient\Pazienti::where ( 'id_utente', Auth::id () )->first ()->id_paziente;
				$PazienteCheck = \App\ConsensoPaziente::where ( 'id_paziente', $PazienteAuth )->get ();
				
				$ConsentInstance = $PazienteCheck->where ( 'Id_Trattamento', $trattamento )->first ();
				\App\Http\Controllers\ConsensiController::createPConsent ($PazienteAuth);
				if ($this->search ( $ConsentInstance, $trattamento)) {
					return $next ( $request );
				}
				
				break;
		}
		$data = array ();
		$data ['trattamento'] = $ConsentInstance->getTrattamentoNome ();
		return response ( view ( 'includes.warningConsent', $data ) );
		// return view ( 'includes.warningConsent', [$trattamento] ); //Deprecato
	}
	public function search($ConsensiArray, $Trattamento) {
		
		$Consenso = $ConsensiArray->Consenso;
		
		if ($Consenso) {
			return true;
		}
		return false;
	}
}
