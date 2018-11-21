<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Http\Requests;

class CookieController extends Controller {
	
	/**
	 * Questo metodo non funziona correttamente, dovrebbe essere richiamato dall'Home Controller tuttavia non imposta i cookie associandoli al dominio
	 *
	 * @param Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public static function setCookie(Request $request) {
		$response = new Response ( '/cookie/index' );
		csrf_field ();
		$response->withCookie ( cookie ( 'consent', now (), 1 ) );
		
		return $response;
	}
	
	/**
	 * Restituisce il valore dei cookie
	 *
	 * @param Request $request        	
	 * @return unknown
	 */
	public static function getCookie(Request $request) {
		$value = $request->cookie ( 'consent' );
		return $value;
	}
	
	/**
	 * Ritorna la view per i cookie
	 *
	 * @return unknown
	 */
	public function index() {
		return view ( 'layouts.cookies-s' );
	}
}
