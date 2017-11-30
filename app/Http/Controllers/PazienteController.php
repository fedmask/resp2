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
    public function updateOrgansDonor (Request $request){
		// TODO: Completare validazione
		$paziente = Pazienti::findByIdUser(Auth::id());
		if(Input::get('patdonorg') === 'acconsento'){
			$paziente->paziente_donatore_organi = 1;
		} else {
			$paziente->paziente_donatore_organi = 0;
		}
		$paziente->save();
		return redirect( '/patient-summary' );
	}
	
	public function updateAnagraphic (Request $request){
		// TODO: Aggiungere validazione
		$paziente = Pazienti::findByIdUser(Auth::id());
		$contatti = Contatti::findByIdUser(Auth::id());
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
}
