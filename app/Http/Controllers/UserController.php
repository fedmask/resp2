<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Hash;
use Input;
use Redirect;
use App\Models\CurrentUser\User;
use App\Models\CurrentUser\Recapiti;
use App\Models\Patient\Pazienti;
use App\Models\CareProviders\CareProvider;
use App\Models\Domicile\Comuni;
use Auth;
use App\Mail\SendMail;
use Mail;

class UserController extends Controller {
	
	/**
	 * Gestisce l'operazione di update della password dell'utente.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 */
	public function updatePassword(Request $request) {
		$validator = Validator::make ( Input::all (), [ 
				'password' => 'required|confirmed',
				'password_confirmation' => 'required|same:password' 
		] );
		
		if ($validator->fails ()) {
			return Redirect::back ()->with ( 'FailEditPassword', 'La password non Ã¨ stata correttamente aggiornata.' )->withErrors ( $validator );
		}
		
		$credentials = $request->only ( 'current_password', 'password', 'password_confirmation' );
		$user = \Auth::user ();
		if (Hash::check ( $credentials ['current_password'], $user->utente_password )) {
			$user->utente_password = bcrypt ( $credentials ['password'] );
			$user->save ();
		} else {
			return "Error, old password not matching";
		}
		return Redirect::back ()->with ( 'SuccessEditPassword', 'La password Ã¨ stata correttamente aggiornata' );
	}
	
	/**
	 * Gestisce l'eliminazione di un accout
	 *
	 * @param Request $request        	
	 */
	public function deleteUser(Request $request) {
		$user = Auth::user ();
		
		switch ($user->getRole ()) {
			
			case $user::PATIENT_ID :
				try {
					Mail::to ( $user->utente_email )->send ( new sendMail ( $user->utente_email, 'Avviso di cancellazione Account', 'Gent.mo utente, la informaimo che il suo account è stato cancellato in data: ' . now () . '. Se non ha effettuato lei la cancellazione la preghiamo di riolgersi ai nostri operatori di Supporto alla mail "privacy@fsem.com" .' ) );
				} catch ( \Exception $E ) {
				} // Da eliminare appena si crea un account smtp.mailtrap.io da aggiungere al file .env
				User::where ( 'id_utente', $user->id_utente )->delete ();
				Recapiti::where ( 'id_utente', $user->id_utente )->delete ();
				Pazienti::where ( 'id_utente', $user->id_utente )->delete ();
				break;
			case $user::CAREPROVIDER_ID :
				try {
					Mail::to ( $user->utente_email )->send ( new sendMail ( $user->utente_email, 'Avviso di cancellazione Account', 'Gent.mo utente, la informaimo che il suo account è stato cancellato in data: ' . now () . '. Se non ha effettuato lei la cancellazione la preghiamo di riolgersi ai nostri operatori di Supporto alla mail "privacy@fsem.com" .' ) );
				} catch ( \Exception $E ) {
				} // Da eliminare appena si crea un account smtp.mailtrap.io da aggiungere al file .env
				
				User::where ( 'id_utente', $user->id_utente )->delete ();
				Recapiti::where ( 'id_utente', $user->id_utente )->delete ();
				CareProvider::where ( 'id_utente', $user->id_utente )->delete ();
				break;
		}
		\Auth::logout();
		return redirect ( '/' );
	}
}