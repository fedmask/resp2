<?php

namespace App\ Http\ Controllers;

use Illuminate\ Http\ Request;
use App\ Http\ Controllers\ Controller;
use Illuminate\Support\Facades\Validator;
use Hash;
use Input;
use Redirect;
use Auth;
use App\Models\Patient\Pazienti;
use App\Models\InvestigationCenter\CentriIndagini;
use App\Models\InvestigationCenter\CentriTipologie;
use App\Models\CareProviders\CppPersona;

class CareProviderController extends Controller {
	
	/**
	* Mostra la pagina contenente la lista di pazienti associata
	* al Care Provider attualmente loggato.
	*/
	public function showPatientsList(){
		$patients = Pazienti::All();
        return view('pages.careprovider.patients')->with('patients', $patients);
	}

	/**
	* Mostra la pagina contenente la lista di tutti i centri diagnostici registrati nel
	* sistema e quelli creati/associati al careprovider attualmente loggato.
	*/
	public function showStructures(){
		$id_persona = CppPersona::where('id_utente', Auth::user()->id_utente)->first()['id_persona'];
		$own_structures = CentriIndagini::where('id_ccp_persona', $id_persona)->get();
        return view('pages.careprovider.structures')->with('own_structures', $own_structures)->with('resp_structures', CentriIndagini::where('centro_resp', 1)->get())->with('structure_types', CentriTipologie::All());
	}

	/**
	* Inserisce nel sistema una nuova struttura associandola al care provider
	*/
	public function addStructure(){
		$validator = Validator::make(Input::all(), [
            'editName' => 'required|string|max:40',
            'editSurname' => 'required|string|max:40',
            'editGender' => 'required',
            'editFiscalCode' => 'required|regex:/[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]/',
            'editEmail' => 'required|string|email|max:50',
            'editBirthTown' => 'required|string|max:40',
            'editBirthdayDate' => 'required|date',
            'editLivingTown' => 'required|string|max:40',
            'editAddress' => 'required|string|max:90',
            'editTelephone' => 'required|numeric',
            'editMaritalStatus' => 'required',
        ]);
	}
	
	
	/**
	 * Serve ad associare un cpp all'utente loggato
	 */
	public function associaCpp($getvalue)
	{
	    $arrayCpp = array();
	    $arrayCpp = CppPaziente::all();
	    $val = false;
	    
	    foreach($arrayCpp as $cpp){
	        if($cpp->id_cpp == $getvalue){
	            $val = true;
	        }
	    }
	    
	    if($val){
	        return Redirect::back();
	    }else{
	        $cpp = CppPaziente::create([
	            'id_cpp'=> $getvalue,
	            'id_paziente'=> Pazienti::where('id_utente', Auth::id())->first()->id_paziente,
	            'assegnazione_confidenzialita'=> '1'
	        ]);
	        
	        $cpp->save();
	        return Redirect::back();
	    }
	}
	
	/**
	 * Serve a modificare la confidenzialit tra l'utente loggato e il cpp selezionato
	 */
	public function modificaConfidenzialita($getValue, $getIdUser, $getIdCpp)
	{
	    $match = ['id_cpp' => $getIdCpp, 'id_paziente' => $getIdUser];
	    
	    $edited_character = \DB::table('tbl_cpp_paziente')->where($match)->update([
	        'assegnazione_confidenzialita' => $getValue
	    ]);
	    return Redirect::back();
	}
	
	/**
	 * Serve a rimuovere la confidenzialit tra l'utente loggato e il cpp selezionato
	 */
	public function rimuoviConfidenzialita($getConf, $getIdUser, $getIdCpp)
	{
	    $match = ['id_cpp' => $getIdCpp, 'id_paziente' => $getIdUser, 'assegnazione_confidenzialita' => $getConf];
	    
	    $edited_character = \DB::table('tbl_cpp_paziente')->where($match)->delete();
	    
	    return Redirect::back();
	}
	

}