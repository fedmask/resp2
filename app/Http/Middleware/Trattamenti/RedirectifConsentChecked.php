<?php

namespace App\Http\Middleware\Trattamenti;

use Closure;

class RedirectifConsentChecked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $trattamento)
    {
    	$user_type = \App\Models\CurrentUser\User::find ( Auth::id () )->id_tipologia;
    	
    	switch ($user_type){
    		
    		case 'mos':
    				
    			$CareProviderAuth = \App\Models\CareProviders\CareProvider::where ( 'id_utente', Auth::id () )->first ()->id_cpp;
    			$CppCheck = \App\ConsensoCareProvider::where ( 'id_Cpp', $CareProviderAuth);
    			if(search($CppCheck, $trattamento)){
    				return $next($request);
    			}
    	
    		case 'ass':
    			
    			$PazienteAuth = \App\Models\Patient\Pazienti::where ( 'id_utente', Auth::id () )->first ()->id_paziente;
    			$PazienteCheck = \App\ConsensoPaziente::where ( 'id_paziente', $PazienteAuthAuth);
    			
    			if(search($PazienteCheck, $trattamento)){
    				return $next($request);
    			}
    	}
       
        
    	 return view ( 'includes.warningConsent', [$trattamento] ); //New blade
        
        
    }
    
    
    public function search($ConsensiArray, $Trattamento){
    	
    	
    	foreach ($ConsensiArray as $Consenso){
    		if($Consenso->getTrattamentoNome()== $Trattamento){
    			return true;
    		}
    		
    }
    return false;
}
}
