<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Contatti;
use App\Pazienti;
use Auth;
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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tbl_utenti,utente_email',
            'password' => 'required|string|min:6'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'utente_nome' => $data['username'],
            'utente_email' => $data['email'],
            'utente_scadenza' => '2030-01-01',
            'utente_tipologia' => '1',      //Paziente
            'utente_email' => $data['email'],
            'utente_password' => bcrypt($data['password']),
        ]);

        
        $user_contacts = Contatti::create([
            'id_paziente' => $user->id_utente,
            'id_comune_residenza' => 1,   //Da sistemare questo valore (può anche non esserci)
            'id_comune_nascita' => 1, //Da sistemare questo valore
            'paziente_telefono'  => $data['telephone'],
            'paziente_indirizzo' => $data['address'],
        ]);
         
        $user_patient = Pazienti::create([
            'id_utente' => $user->id_utente,
            'id_paziente_contatti' => $user->id_utente,
            'paziente_nome' => $data['name'],
            'paziente_cognome' => $data['surname'],
            'paziente_sesso' => $data['gender'],
            'paziente_codfiscale' => str_replace("-", "", $data['CF']),
            'paziente_nascita' => date('Y-m-d', strtotime($data['birthDate'])),
            'paziente_gruppo' => '0',//$data['bloodType'],
            'paziente_rh' => 1, //TODO: CAMBIARE!
            'paziente_stato_matrimoniale' => $data['maritalStatus'],
        ]);

        //Restituisco $user perchè servirà per il login successivo
        return $user && $user_contacts && $user_patient ? $user : false;
    }
    
    /*
    * Gestisce la view da visualizzare per la registrazione dei pazienti
    */
    public function showPatientRegistrationForm(){
        if(!Auth::guest())
            return redirect()->route('home'); // se si è già loggati si va alla home
        return view('auth.register-patient');
    }
}
