<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Pazienti;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use DateTime;
use DB;

class PatientRegisterController extends Controller
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
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
        
        die("create");
        /*
		$user = User::create([
            'name' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
		
		/*
		Pazienti::create([
			'id_utente' => $user->id,
			'id_paziente_contatti' => $user->id,
			'paziente_nome' => $data['name'],
			'paziente_cognome' => $data['surname'],
			'paziente_sesso' => $data['gender'],
			'paziente_codfiscale' => $data['CF'],
			'paziente_nascita' => date('y/m/d', $data['birthDate']),
			'paziente_gruppo' => $data['bloodType'],
			'paziente_rh' => $data['bloodType'], //TODO: CAMBIARE!
			'paziente_rh' => 1, //TODO: CAMBIARE!
			'paziente_stato_matrimoniale' => $data['maritalStatus'],
		]); */
		
        return ($user);
    }
	
	
	public function store(Request $request)
    {
       
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tbl_utenti,utente_email',
            'password' => 'required|string|min:6|confirmed'
        ]);
        
        die("stop");

        die("store stop");
		/* Working in test
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
			'role' => 'required',
        ]);
        
        $user = User::create(request(['name', 'email', 'password', 'role'])); */
		
        /*
		$user = User::create([
            'name' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
			'role' => $request->input('role'),
        ]);
		$user->save();
		$date = $date = DateTime::createFromFormat('d-m-Y', $request->input('birthDate'));
		$date->format('Y-m-d');
		
		$data = array('id_utente' => $user->id,
			'id_paziente_contatti' => $user->id,
			'paziente_nome' => $request->input('name'),
			'paziente_cognome' => $request->input('surname'),
			'paziente_sesso' => $request->input('gender'),
			'paziente_codfiscale' => str_replace("-","",$request->input('CF')),
			'paziente_nascita' => $date,
			'paziente_gruppo' => $request->input('bloodType'),
			'paziente_rh' => 1, //TODO: CAMBIARE!
			'paziente_stato_matrimoniale' => $request->input('maritalStatus'));
		DB::table(tbl_pazienti)->insert($data);
		
		/*
		$paziente = Pazienti::create([
			'id_utente' => $user->id,
			'id_paziente_contatti' => $user->id,
			'paziente_nome' => $request->input('name'),
			'paziente_cognome' => $request->input('surname'),
			'paziente_sesso' => $request->input('gender'),
			'paziente_codfiscale' => str_replace("-","",$request->input('CF')),
			'paziente_nascita' => $date,
			'paziente_gruppo' => $request->input('bloodType'),
			'paziente_rh' => 1, //TODO: CAMBIARE!
			'paziente_stato_matrimoniale' => $request->input('maritalStatus'),
		]);
		
		$paziente->save();
        
        auth()->login($user);
        
        return redirect()->to('/home'); */
    }
}
