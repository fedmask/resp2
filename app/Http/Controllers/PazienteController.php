<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pazienti;
use App\User;
use App\Contatti;
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
		$paziente = Pazienti::find(Auth::id());
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
		// TODO: Aggiungere validazione
		$paziente = Pazienti::find(Auth::id());
		$contatti = Contatti::find(Auth::id());
		$user = \Auth::user();
		
		$paziente->paziente_nome = Input::get('editName');
		$paziente->paziente_cognome = Input::get('editSurname');
		$paziente->paziente_codfiscale = Input::get('editFiscalCode');
		$paziente->paziente_nascita = Input::get('editBirthdayDate');
		$paziente->paziente_sesso = Input::get('editGender');
		$paziente->paziente_stato_matrimoniale = Input::get('editMaritalStatus');
		
		if($paziente->contacts['paziente_indirizzo'] != Input::get('editAddress')){
			$contatti->paziente_indirizzo = Input::get('editAddress');
		}
		
		if($paziente->contacts['id_comune_nascita'] != Input::get('editBirthTown')){
			$current = Input::get('editBirthTown');
			$contatti->id_comune_nascita = DB::table('tbl_comuni')->where('comune_nominativo', $current)->first()->id_comune;
		}
		
		if($paziente->contacts['id_comune_residenza'] != Input::get('editLivingTown')){
			$current = Input::get('editLivingTown');
			$contatti->id_comune_residenza = DB::table('tbl_comuni')->where('comune_nominativo', $current)->first()->id_comune;
		}
		
		$contatti->paziente_telefono = Input::get('editTelephone');
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
}
