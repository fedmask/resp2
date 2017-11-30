<?php

namespace App\ Http\ Controllers;

use Illuminate\ Http\ Request;
use App\ Http\ Controllers\ Controller;
use Hash;

class UserController extends Controller {
	
	public function updatePassword( Request $request ) {
		$this->validate( $request, ['password' => 'required|confirmed',]);
		$credentials = $request->only( 'current_password', 'password', 'password_confirmation' );
		$user = \Auth::user();
		if ( Hash::check( $credentials[ 'current_password' ], $user->utente_password ) ) {
			$user->utente_password = bcrypt( $credentials[ 'password' ] );
			$user->save();
		} else {
			return "Error, old password not matching";
		}
		return redirect( '/patient-summary' );
	}
}