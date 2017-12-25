<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Recapiti;
use App\Models\Pazienti;
use Auth;
use Redirect;
use Input;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

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
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    /*
    * Gestisce la view da visualizzare per la registrazione dei pazienti
    */
    public function showPatientRegistrationForm(){
        if(!Auth::guest())
            return redirect()->route('home'); // se si è già loggati si va alla home
        return view('auth.register-patient');
    }

    /*
    * Gestisce la view da visualizzare per la registrazione dei care provider
    */
    public function showCareProviderRegistrationForm(){
        if(!Auth::guest())
            return redirect()->route('home'); // se si è già loggati si va alla home
        return view('auth.register-careprovider');
    }

    /**
     * Registra un nuovo paziente nel sistema, dopo aver
     * validato i dati inseriti nel form apposito.
     * Una volta effettuata la registrazione, il paziente viene
     * automaticamente loggato e reindirizzato alla home del profilo.
     *
     */
    protected function registerPatient(){
        $validator = Validator::make(Input::all(), [
            'acceptTerms' => 'bail|accepted',
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
            'maritalStatus' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = User::create([
            'utente_nome' => Input::get('username'),
            'utente_email' => Input::get('email'),
            'utente_scadenza' => '2030-01-01', // TODO: Definire meglio
            'utente_tipologia' => '1',      //Paziente
            'utente_email' => Input::get('email'),
            'utente_password' => bcrypt(Input::get('password')),
        ]);

        $user_contacts = Recapiti::create([
            'id_utente' => $user->id_utente,
            'id_comune_residenza' => 1,   // TODO: Da sistemare questo valore (può anche non esserci)
            'id_comune_nascita' => 1, // TODO: Da sistemare questo valore
            'contatto_telefono'  => Input::get('telephone'),
            'contatto_indirizzo' => Input::get('address'),
        ]);

        $user_patient = Pazienti::create([
            'id_utente' => $user->id_utente,
            'id_paziente_contatti' => $user->id_utente,
            'paziente_nome' => Input::get('name'),
            'paziente_cognome' => Input::get('surname'),
            'paziente_sesso' => Input::get('gender'),
            'paziente_codfiscale' => str_replace("-", "", Input::get('CF')),
            'paziente_nascita' => date('Y-m-d', strtotime(Input::get('birthDate'))),
            'paziente_gruppo' => Input::get('bloodType'),
            'paziente_rh' => 1, //TODO: CAMBIARE!
            'paziente_stato_matrimoniale' => Input::get('maritalStatus'),
        ]);

        $user->save();
        $user_contacts->save();
        $user_patient->save();

        $credentials = array('email' => Input::get('email'), 'password' => Input::get('password'));
        if (Auth::attempt($credentials)) {
            return Redirect::to('home');
        }

        return redirect('/');
    }
}
