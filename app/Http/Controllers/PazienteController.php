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
use App\Models\CareProviders\CareProvider;
use App\Models\CareProviders\CppPaziente;
use App\Models\Log\AuditlogLog;
use App\Models\UtentiTipologie;
use App\Models\File;
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
    public function showCalcolatriceMedica(Request $request){
    	if ($request->has('id_visiting')) {
		    $id_visiting = request()->input('id_visiting');
		} else {
			$id_visiting = Auth::user()->id_utente;
		}

		$this->buildLog('Calcolatrice medica', $request->ip(), $id_visiting);
        return view('pages.calcolatrice-medica');
    }

    /**
    * Mostra la patient summary del paziente del paziente
    */
    public function showPatientSummary(Request $request){
    	if ($request->has('id_visiting')) {
    		$id_visiting = request()->input('id_visiting');
    	} else {
    		$id_visiting = Auth::user()->id_utente;
    	}
    	
    	$this->buildLog('Patient summary', $request->ip(), $id_visiting);
    	$contacts = PazientiContatti::where('id_paziente', Auth::user()->patient()->first()->id_paziente)->get();
    	return view('pages.patient-summary')->with('contacts', $contacts);
    }

    /**
    * Mostra il taccuino di un paziente
    */
    public function showTaccuino(Request $request){
    	$user = Auth::user();
    	if ($request->has('id_visiting')) {
		    $id_visiting = request()->input('id_visiting');
		} else {
			$id_visiting = Auth::user()->id_utente;
		}

		$this->buildLog('Taccuino', $request->ip(), $id_visiting);
 
    	if($user->getDescription() == $user::PATIENT_DESCRIPTION){
    		$records = Taccuino::where('id_paziente', $user->patient()->first()->id_paziente)->get();
    	}
        return view('pages.taccuino')->with('records', $records);
    }

    /**
    * Mostra la pagina dei Care Providers associati ad un paziente
    */
    public function showCareProviders(Request $request){
    	$user = Auth::user();
    	if ($request->has('id_visiting')) {
		    $id_visiting = request()->input('id_visiting');
		} else {
			$id_visiting = Auth::user()->id_utente;
		}

		$this->buildLog('Care Providers', $request->ip(), $id_visiting);

    	$records = [];
    	if($user->getDescription() == User::PATIENT_DESCRIPTION){
    		$id_patient = $user->patient()->first()->id_paziente;
    		// Preleva l'id di tutti i careprovider associati al paziente attulmente loggato.
    		$id_careproviders = CppPaziente::where('id_paziente', $id_patient)->get();

    		for ($i = 0; $i < count($id_careproviders); $i++) {
			  $careprovider = CareProvider::where('id_cpp', $id_careproviders[$i])->first();
			  $records[$i] = $careprovider;
			}
    	}
        return view('pages.careproviders')->with('careproviders', $records)->with('types', UtentiTipologie::all());
    }

    /**
	* Mostra la sezione dei files associati ad un paziente
	*/
	public function showFiles(Request $request){
		$user = Auth::user();
		$files = [];


		if ($request->has('id_visiting')) {
		    $id_visiting = request()->input('id_visiting');
		} else {
			$id_visiting = Auth::user()->id_utente;
		}

		$log = $this->buildLog('Files', $request->ip(), $id_visiting);

		if($user->getDescription() == User::PATIENT_DESCRIPTION){
			$files = File::where('id_paziente', $id_patient = $user->patient()->first()->id_paziente)->get();
		}
		

		$under18 = true;
		
		if($user->getAge ( date ( 'd-m-Y', strtotime ( str_replace ( '/', '-', $user->patient()->first()->paziente_nascita) ) ) )<18){
			
			$under18 = false;
			
		}
			
		
		return view('pages.files')->with('files', $files)->with('log', $log)->with('under18', $under18);
	}

	/**
	* Mostra la pagina delle impostazioni di sicurezza in cui 
	* è possibile vedere anche il registro degli accessi.
	*/
	public function showSecuritySettings(Request $request){
		if ($request->has('id_visiting')) {
		    $id_visiting = request()->input('id_visiting');
		} else {
			$id_visiting = Auth::user()->id_utente;
		}

		$this->buildLog('Impostazioni sicurezza', $request->ip(), $id_visiting);

		$logs = AuditlogLog::where('id_visitato', $id_visiting)->orderBy('id_audit', 'desc')->get();

		return view('pages.impostazioni-sicurezza')->with('logs', $logs);
	}

	/**
	* Mostra la pagina delle visite di un paziente in cui vengono
	* memorizzate anche alcune rilevazioni.
	*/
	public function showVisits(Request $request){


		if ($request->has('id_visiting')) {

            $id_visiting = request()->input('id_visiting');

		} else {

            $id_visiting = Auth::user()->id_utente;

        }


		$this->buildLog('Visite', $request->ip(), $id_visiting);


		$logs = AuditlogLog::where('id_visitato', $id_visiting)->orderBy('id_audit', 'desc')->get();

		return view('pages.visite')->with('logs', $logs);
	}

	/*
	* Costruisce un nuovo record log per la pagina che si sta per visualizzare
	*/
	public function buildLog($actionName, $ip, $id_visiting){
		$log = AuditlogLog::create([ 'audit_nome' => $actionName,
				'audit_ip' => $ip,
				'id_visitato' => $id_visiting,
				'id_visitante' => Auth::user()->id_utente,
				'audit_data' => date('Y-m-d H:i:s'),
			]);

		$bool=$log->save();

		return $log;
	}

	/**
	 * mostra la pagina Diagnosi
	 */
	public function showDiagnosi(Request $request){
	    if ($request->has('id_visiting')) {
	        $id_visiting = request()->input('id_visiting');
	    } else {
	        $id_visiting = Auth::user()->id_utente;
	    }
	    
	    $this->buildLog('Diagnosi', $request->ip(), $id_visiting);
	    
	    $logs = AuditlogLog::where('id_visitato', $id_visiting)->orderBy('id_audit', 'desc')->get();
	    
	    return view('pages.diagnosi')->with('logs', $logs);
	}
	
	
	
	/**
	 * mostra la pagina Indagini
	 */
	public function showIndagini(Request $request){
	    if ($request->has('id_visiting')) {
	        $id_visiting = request()->input('id_visiting');
	    } else {
	        $id_visiting = Auth::user()->id_utente;
	    }
	    
	    $this->buildLog('Indagini', $request->ip(), $id_visiting);
	    
	    $logs = AuditlogLog::where('id_visitato', $id_visiting)->orderBy('id_audit', 'desc')->get();
	    
	    return view('pages.indagini')->with('logs', $logs);
	}
	
	
	/**
	 * mostra la pagina Vaccinazioni
	 */
	public function showVaccinazioni(Request $request){
	    if($request->has('id_visiting')) {
	        $id_visiting = request()->input('id_visiting');
	    } else {
	        $id_visiting = Auth::user()->id_utente;
	    }
	    
	    $this->buildLog('Vaccinazioni', $request->ip(), $id_visiting);
	    
	    $logs = AuditlogLog::where('id_visitato', $id_visiting)->orderBy('id_audit', 'desc')->get();
	    
	    return view('pages.vaccinazioni')->with('logs', $logs);
	}
}
