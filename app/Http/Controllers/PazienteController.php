<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient\Pazienti;
use App\Models\CurrentUser\User;
use App\Models\CurrentUser\Recapiti;
use App\Models\Domicile\Comuni;
use App\Models\Patient\Taccuino;
use App\Models\Patient\PazientiContatti;
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
	* Aggiunge un nuovo contatto telefonico tra
	* quelli associati al paziente.
	*/
	public function addContact(){
		$validator = Validator::make(Input::all(), [
			'modcontemerg_add2' => 'required|string|max:40',
			'modtelcontemerg_add2' => 'required|numeric',
			'modtipcontemerg_add2' => 'required',  
		]);

		if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $contact = PazientiContatti::create([
            'id_paziente' => Pazienti::where('id_utente', Auth::id())->first()->id_paziente,
            'contatto_nominativo' => Input::get('modcontemerg_add2'),
            'contatto_telefono' => Input::get('modtelcontemerg_add2'),
            'id_contatto_tipologia' => $this->getContactType(Input::get('modtipcontemerg_add2')),
        ]);

        $contact->save();
        return Redirect::back()->with('contact_added');
	}

	private function getContactType($type_contact_name){
		switch ($type_contact_name) {
			case 'Familiare':
				return 0;
				break;
			case 'Tutore':
				return 1;
				break;
			case 'Amico':
				return 2;
				break;
			case 'Compagno':
				return 3;
				break;
			case 'Lavorativo':
				return 4;
				break;
			case 'Badante':
				return 5;
				break;
			case 'Delegato':
				return 6;
				break;
			case 'Garante':
				return 7;
				break;
			case 'Padrone':
				return 8;
				break;
			case 'Genitore':
				return 9;
				break;
			default:
				return 'Undifined';
				break;
		}
	}

	/**
	* Aggiunge un nuovo contatto telefonico tra
	* quelli associati al paziente.
	*/
	public function addEmergencyContact(){
		$validator = Validator::make(Input::all(), [
			'modcontemerg_add' => 'required|string|max:40',
			'modtelcontemerg_add' => 'required|numeric',
		]);

		if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $contact = PazientiContatti::create([
            'id_paziente' => Pazienti::where('id_utente', Auth::id())->first()->id_paziente,
            'contatto_nominativo' => Input::get('modcontemerg_add'),
            'contatto_telefono' => Input::get('modtelcontemerg_add'),
            'id_contatto_tipologia' => '10',
        ]);

        $contact->save();
        return Redirect::back()->with('contact_added');
	}

	/**
	* Aggiunge un nuovo contatto telefonico tra
	* quelli associati al paziente.
	*/
	public function removeContact(){
		$contact = PazientiContatti::find(Input::get('id_contact'));
		$contact->delete();
		return Redirect::back()->with('contact_deleted');
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
    	$contacts = PazientiContatti::where('id_paziente', Auth::user()->patient()->first()->id_paziente)->get();
        return view('pages.patient-summary')->with('contacts', $contacts);
    }

    /**
    * Mostra il taccuino di un paziente
    */
    public function showTaccuino(){
    	$user = Auth::user();
 
    	if($user->getRole() == $user::PATIENT_DESCRIPTION){
    		$records = Taccuino::where('id_paziente', $user->patient()->first()->id_paziente)->get();
    	}
        return view('pages.taccuino')->with('records', $records);
    }
}
