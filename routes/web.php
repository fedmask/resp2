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
Route::post('/register/careprovider', 'Auth\RegisterController@registerCareprovider');



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
* Route per aggiungere un numero telefonico di un conoscente/familiare ad un paziente
*/
Route::post('/pazienti/addContact', 'PazienteController@addContact');

/**
* Route per aggiungere un numero telefonico di emergenza di un conoscente/familiare ad un paziente
*/
Route::post('/pazienti/addEmergencyContact', 'PazienteController@addEmergencyContact');


/**
* Route per rimuovere un numero telefonico di un conoscente/familiare ad un paziente
*/
Route::post('/pazienti/removeContact', 'PazienteController@removeContact');

/**
* Route per l'inserimento di una nuova segnalazione all'interno del taccuino
*/
Route::post('/pazienti/taccuino/addReporting', 'TaccuinoController@addReporting');

/**
* Route per la rimozione di una segnalazione all'interno del taccuino
*/
Route::post('/pazienti/taccuino/removeReporting', 'TaccuinoController@removeReporting');

/**
* Route per la gestione dell'invio di mail di suggerimento
*/
Route::get('/send-suggestion', 'MailController@sendSuggestion');

/**
* Route per l'upload di un file associandolo ad un paziente
*/
Route::post('/uploadFile', 'FilesController@uploadFile');

/**
* Route per la rimozione di un file associato ad un paziente
*/
Route::post('/deleteFile', 'FilesController@deleteFile');

/**
 * Route per il download di un immagine
 */
Route::get('/downloadImage/{id_photo}', 'FilesController@downloadImage');


/**
* Route per l'aggiornamento del livello di confidenzialità
* associato ad un file
*/
Route::post('/updateFileConfidentiality', 'FilesController@updateFileConfidentiality');

/**
* Route per l'inserimento da parte di un careprovider di un nuovo centro.
*/
Route::post('/addstructure', 'CareProviderController@addStructure');


/*
* Routes base per le varie pagine e reindirizza gli utenti non loggati alla homepage
*/
Route::group(['middleware' => ['auth']], function () {

	// Inizio Route Paziente
	Route::get('/utility', function(){return view('pages.utility');})->name('utility');

	Route::get('/calcolatrice-medica', 'PazienteController@showCalcolatriceMedica')->name('calcolatrice-medica');

	Route::get('/patient-summary', 'PazienteController@showPatientSummary')->name('patient-summary');

	Route::get('/taccuino', 'PazienteController@showTaccuino')->name('taccuino');

	Route::get('/careproviders', 'PazienteController@showCareProviders')->name('careproviders');

	Route::get('/files', 'PazienteController@showFiles')->name('files');

	Route::get('/visits', 'PazienteController@showVisits')->name('visite');

	Route::get('/impostazioniSicurezza', 'PazienteController@showSecuritySettings')->name('securitySettings');

	// Inizio Routes Care Provider
	Route::get('/patients-list', 'CareProviderController@showPatientsList')->name('patients-list');

	Route::get('/structures', 'CareProviderController@showStructures')->name('structures');

});

Route::group( ['prefix' => 'fhir', 'middleware' => ['App\Http\Middleware\CareProviderMiddleware'] ], function () {
        
    Route::get('Patient/{id?}', 'Fhir\Modules\FHIRPatient@getResource');
    Route::get('Practitioner/{id?}','Fhir\Modules\FHIRPractitioner@getResource');
    Route::get('Organization/{id?}','Fhir\Modules\FHIROrganization@getResource');
    Route::get('Observation/{id?}','Fhir\Modules\FHIRObservation@getResource');
    Route::get('DiagnosticReport/{id?}','Fhir\Modules\FHIRDiagnosticReport@getResource');
    
    //
    Route::post('Patient', 'Fhir\Modules\FHIRPatient@createResource');
    
   // Route::put('Patient/{id}', 'Fhir\Modules\FHIRPatient@update');
   // Route::delete('Patient/{id}', 'Fhir\Modules\FHIRPatient@destroy');

});

Route::get("TestSend", "Fhir\Modules\FHIRPatient@setPage");


        
