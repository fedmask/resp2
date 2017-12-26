<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
* Route per l'index
*/
Route::get('/', function () { return view('welcome'); });

/**
* Route per la pagina principale della web application
*/
Route::get('/home', 'HomeController@index')->name('home');

/**
* Routes per la registrazione di Pazienti e Care Provider
*/
Route::get('/register', function() { return view('auth.register'); });
Route::get('/register/patient', 'Auth\RegisterController@showPatientRegistrationForm')->name('register_patient');
Route::post('/register/patient', 'Auth\RegisterController@registerPatient');
Route::get('/register/careprovider', 'Auth\RegisterController@showCareProviderRegistrationForm')->name('register_careprovider');


/*
 * 
 * Auth::routes(); chiama e istanzia le seguenti funzioni/url
 * $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
 * $this->post('login', 'Auth\LoginController@login');
 * $this->post('logout', 'Auth\LoginController@logout')->name('logout');
 ** Registration Routes...
 * $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
 * $this->post('register', 'Auth\RegisterController@register');
 ** Password Reset Routes...
 * $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
 * $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
 * $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
 * $this->post('password/reset', 'Auth\ResetPasswordController@reset');
 */
Auth::routes();

/**
* Route per effettuare l'update della password
*/
Route::post('/user/updatepassword', 'UserController@updatePassword');

/**
* Route per effettuare l'update del consenso alla donazione organi da parte
* del paziente.
*/
Route::post('/pazienti/updateOrgansDonor', 'PazienteController@updateOrgansDonor');

/**
* Route per effettuare l'update dell'anagrafica del paziente
*/
Route::post('/pazienti/updateAnagraphic', 'PazienteController@updateAnagraphic');

/**
* Route per la gestione dell'invio di mail di suggerimento
*/
Route::get('/send-suggestion', 'MailController@sendSuggestion');


/*
* Routes base per le varie pagine e reindirizza gli utenti non loggati alla homepage
*/
Route::group(['middleware' => ['auth']], function () {

	// Definito fuori da un controller poichè non accede ad alcun dato
	Route::get('/links', function(){return view('pages.links');})->name('links');

	Route::get('/calcolatrice-medica', 'PazienteController@showCalcolatriceMedica')->name('calcolatrice-medica');

	Route::get('/patient-summary', 'PazienteController@showPatientSummary')->name('patient-summary');

});
