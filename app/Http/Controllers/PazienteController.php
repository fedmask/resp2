<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pazienti;
use App\Models\User;
use App\Models\Recapiti;
use App\Models\Comuni;
use Validator;
use Redirect;
use Auth;
use DB;
use Input;

class PazienteController extends Controller
{
	/**
	* Gestisce l'operazione di update per il consenso
	* alla donazione degli organi.
	*
	* @param  \Illuminate\Http\Request  $request
	*/
    public function updateOrgansDonor (Request $request){
		// TODO: Completare validazione
		$paziente = Pazienti::where('id_utente', Auth::id())->first();
		if(Input::get('patdonorg') === 'acconsento'){
			$paziente->paziente_donatore_organi = 1;
		} else {
			$paziente->paziente_donatore_organi = 0;
		}
		$paziente->save();
		return redirect( '/patient-summary' );
	}
	
	/**
	* Gestisce l'operazione di update delle informazioni
	* anagrafiche del paziente.
	*
	* @param  \Illuminate\Http\Request  $request
	*/
	public function updateAnagraphic (Request $request){
		$paziente = Pazienti::where('id_utente', Auth::id())->first();
		$user = Auth::user();
		$contatti = $user->contacts()->first();

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

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
		
		$paziente->paziente_nome = Input::get('editName');
		$paziente->paziente_cognome = Input::get('editSurname');
		$paziente->paziente_codfiscale = Input::get('editFiscalCode');
		$paziente->paziente_nascita = Input::get('editBirthdayDate');
		$paziente->paziente_sesso = Input::get('editGender');
		$paziente->id_stato_matrimoniale = Input::get('editMaritalStatus');
		
		if($contatti->contatto_indirizzo != Input::get('editAddress')){
			$user->contacts()->first()->contatto_indirizzo = Input::get('editAddress');
		}
		
		if($contatti->id_comune_nascita != Input::get('editBirthTown')){
			$current = Input::get('editBirthTown');
			$contatti->id_comune_nascita = Comuni::where('comune_nominativo', $current)->first()->id_comune;
		}
		
		if($contatti->id_comune_residenza != Input::get('editLivingTown')){
			$current = Input::get('editLivingTown');
			$contatti->id_comune_residenza = Comuni::where('comune_nominativo', $current)->first()->id_comune;
		}
		
		$contatti->contatto_telefono = Input::get('editTelephone');
		$user->utente_email = Input::get('editEmail');
		
		$paziente->save();
		$user->save();
		$contatti->save();
		return redirect( '/patient-summary' );
	}

	/**
    * Mostra la calcolatrice medica del paziente
    */
    public function showCalcolatriceMedica(){
        return view('pages.calcolatrice-medica');
    }

    /**
    * Mostra la patient summary del paziente del paziente
    */
    public function showPatientSummary(){
        return view('pages.patient-summary');
    }

    /**
    * Mostra la patient summary del paziente del paziente
    */
    public function showTaccuino(){
        return view('pages.taccuino');
    }
}
