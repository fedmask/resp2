<?php

namespace App\Http\Controllers\Auth;

use App\Models\CurrentUser\User;
use App\Models\CurrentUser\Recapiti;
use App\Models\Patient\Pazienti;
use App\Models\CareProviders\CareProvider;
use App\Models\Domicile\Comuni;
use Auth;
use Redirect;
use Input;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller {
	/*
	 * |--------------------------------------------------------------------------
	 * | Register Controller
	 * |--------------------------------------------------------------------------
	 * |
	 * | This controller handles the registration of new users as well as their
	 * | validation and creation. By default this controller uses a trait to
	 * | provide this functionality without requiring any additional code.
	 * |
	 */
	
	use RegistersUsers;
	private $bloodGroup = null;
	private $bloodRh = null;
	
	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware ( 'guest' );
	}
	
	/*
	 * Gestisce la view da visualizzare per la registrazione dei pazienti
	 */
	public function showPatientRegistrationForm() {
		if (! Auth::guest ())
			return redirect ()->route ( 'home' ); // se si � gi� loggati si va alla home
		return view ( 'auth.register-patient' );
	}
	
	/*
	 * Gestisce la view da visualizzare per la registrazione dei care provider
	 */
	public function showCareProviderRegistrationForm() {
		if (! Auth::guest ())
			return redirect ()->route ( 'home' ); // se si � gi� loggati si va alla home
		return view ( 'auth.register-careprovider' );
	}
	
	/**
	 * Registra un nuovo paziente nel sistema, dopo aver
	 * validato i dati inseriti nel form apposito.
	 * Una volta effettuata la registrazione, il paziente viene
	 * automaticamente loggato e reindirizzato alla home del profilo.
	 */
	protected function registerPatient() {
		$this->getBloodType ( Input::get ( 'bloodType' ) );
		$validator = Validator::make ( Input::all (), [ 
				'acceptInfo' => 'bail|accepted',
				'username' => 'required|string|max:40|unique:tbl_utenti,utente_nome',
				'name' => 'required|string|max:40',
				'surname' => 'required|string|max:40',
				'gender' => 'required',
				'CF' => 'required|regex:/[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]/',
				'email' => 'required|string|email|max:50|unique:tbl_utenti,utente_email',
				'confirmEmail' => 'required|same:email',
				'password' => 'required|min:8|max:16',
				'confirmPassword' => 'required|same:password',
				'birthCity' => 'required|string|max:40',
				'birthDate' => 'required|date|before:-18 years',
				'livingCity' => 'required|string|max:40',
				'address' => 'required|string|max:90',
				'telephone' => 'required|numeric',
				'bloodType' => 'required',
				'maritalStatus' => 'required' 
		
		] );
		
		if ($validator->fails ()) {
			return Redirect::back ()->withErrors ( $validator )->withInput ();
		}
		
		$user = User::create ( [ 
				'utente_nome' => Input::get ( 'username' ),
				'utente_email' => Input::get ( 'email' ),
				'utente_scadenza' => '2030-01-01', // TODO: Definire meglio
				'id_tipologia' => 'ass',
				'utente_email' => Input::get ( 'email' ),
				'utente_password' => bcrypt ( Input::get ( 'password' ) ) 
		] );
		
		$user_contacts = Recapiti::create ( [ 
				'id_utente' => $user->id_utente,
				'id_comune_residenza' => $this->getTown ( Input::get ( 'livingCity' ) ),
				'id_comune_nascita' => $this->getTown ( Input::get ( 'birthCity' ) ),
				'contatto_telefono' => Input::get ( 'telephone' ),
				'contatto_indirizzo' => Input::get ( 'address' ) 
		] );
		
		$user_patient = Pazienti::create ( [ 
				'id_utente' => $user->id_utente,
				'id_paziente_contatti' => $user->id_utente,
				'paziente_nome' => Input::get ( 'name' ),
				'paziente_cognome' => Input::get ( 'surname' ),
				'paziente_sesso' => Input::get ( 'gender' ),
				'paziente_codfiscale' => str_replace ( "-", "", Input::get ( 'CF' ) ),
				'paziente_nascita' => date ( 'Y-m-d', strtotime ( Input::get ( 'birthDate' ) ) ),
				'paziente_gruppo' => $this->bloodGroup,
				'paziente_rh' => $this->bloodRh,
				'id_stato_matrimoniale' => Input::get ( 'maritalStatus' ),
                'paziente_lingua' => "it-IT" //TODO: Inserire la possibilità di scegliere la nazionalità del paziente, usare dati tabella Languages
		] );
		
		
		
		$user->save ();
		$user_contacts->save ();                 
		$user_patient->save ();
		
		/**
		 * Creo i consensi per un Paziente
		 */
		\App\Http\Controllers\ConsensiController::createPConsent($user_patient->id_paziente);
		
		
		
		
		$credentials = array (
				'email' => Input::get ( 'email' ),
				'password' => Input::get ( 'password' ) 
		);
		if (Auth::attempt ( $credentials )) {
			return Redirect::to ( 'home' );
		}
		
		return redirect ( '/' );
	}
	
	/**
	 * Identifica l'id di una citt� presente nel database
	 * a partire dal nome
	 */
	private function getTown($name) {
		return Comuni::where ( 'comune_nominativo', '=', $name )->first ()->id_comune;
	}
	
	
	/**
	 * Identifica un gruppo sanguigno e l'rh in fase di registrazione
	 */
	private function getBloodType($bloodType) {
		switch ($bloodType) {
			case '0' :
				$this->bloodGroup = Pazienti::BLOODGROUP_0;
				$this->bloodRh = 'NEG';
				break;
			case '1' :
				$this->bloodGroup = Pazienti::BLOODGROUP_0;
				$this->bloodRh = 'POS';
				break;
			case '2' :
				$this->bloodGroup = Pazienti::BLOODGROUP_A;
				$this->bloodRh = 'NEG';
				break;
			case '3' :
				$this->bloodGroup = Pazienti::BLOODGROUP_A;
				$this->bloodRh = 'POS';
				break;
			case '4' :
				$this->bloodGroup = Pazienti::BLOODGROUP_B;
				$this->bloodRh = 'NEG';
				break;
			case '5' :
				$this->bloodGroup = Pazienti::BLOODGROUP_B;
				$this->bloodRh = 'POS';
				break;
			case '6' :
				$this->bloodGroup = Pazienti::BLOODGROUP_AB;
				$this->bloodRh = 'NEG';
				break;
			case '7' :
				$this->bloodGroup = Pazienti::BLOODGROUP_AB;
				$this->bloodRh = 'POS';
				break;
			default :
				return 'undefined';
				break;
		}
	}
	public function registerCareprovider() {
		$validator = Validator::make ( Input::all (), [ 
				'acceptInfo' => 'bail|accepted',
				'username' => 'required|string|max:40|unique:tbl_utenti,utente_nome',
				'email' => 'required|string|email|max:50|unique:tbl_utenti,utente_email',
				'confirmEmail' => 'required|same:email',
				'password' => 'required|min:8|max:16',
				'confirmPassword' => 'required|same:password',
				'numOrdine' => 'required|numeric',
				'registrationCity' => 'required',
				'surname' => 'required|string|max:40',
				'name' => 'required|string|max:40',
				'gender' => 'required',
				'CF' => 'required|regex:/[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]/',
				'birthCity' => 'required|string|max:40',
				'birthDate' => 'required|date|before:-18 years',
				'livingCity' => 'required|string|max:40',
				'address' => 'required|string|max:90',
				'cap' => 'numeric|size:5',
				'telephone' => 'required|numeric' 
		] );
		
		if ($validator->fails ()) {
			return Redirect::back ()->withErrors ( $validator )->withInput ();
		}
		
		$user = User::create ( [ 
				'utente_nome' => Input::get ( 'username' ),
				'utente_email' => Input::get ( 'email' ),
				'utente_scadenza' => '2030-01-01', // TODO: Definire meglio
				'id_tipologia' => 'mos', // TODO: In futuro andr� cambiato in base al ruolo del cpp (medico/operatore emergenza/ecc...)
				'utente_email' => Input::get ( 'email' ),
				'utente_password' => bcrypt ( Input::get ( 'password' ) ) 
		] );
		
		$user_contacts = Recapiti::create ( [ 
				'id_utente' => $user->id_utente,
				'id_comune_residenza' => $this->getTown ( Input::get ( 'livingCity' ) ),
				'id_comune_nascita' => $this->getTown ( Input::get ( 'birthCity' ) ),
				'contatto_telefono' => Input::get ( 'telephone' ),
				'contatto_indirizzo' => Input::get ( 'address' ) 
		] );
		
		$user_careprovider = CareProvider::create ( [ 
				'id_utente' => $user->id_utente,
				'cpp_nome' => Input::get ( 'name' ),
				'cpp_cognome' => Input::get ( 'surname' ),
				'cpp_nascita_data' => date ( 'Y-m-d', strtotime ( Input::get ( 'birthDate' ) ) ),
				'cpp_codfiscale' => Input::get ( 'CF' ),
				'cpp_sesso' => Input::get ( 'gender' ),
				'cpp_n_iscrizione' => Input::get ( 'numOrdine' ),
				'cpp_localita_iscrizione' => Input::get ( 'registrationCity' ),
                'cpp_lingua' => "it-IT" //TODO: Inserire la possibilità di scegliere la nazionalità del careprovider, usare dati tabella Languages
		] );
		
		$user->save ();
		$user_contacts->save ();
		$user_careprovider->save ();
		
		$credentials = array (
				'email' => Input::get ( 'email' ),
				'password' => Input::get ( 'password' ) 
		);
		if (Auth::attempt ( $credentials )) {
			return Redirect::to ( 'home' );
		}
		
		return redirect ( '/' );
	}
}
