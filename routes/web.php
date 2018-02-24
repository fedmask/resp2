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


/*
* Routes base per le varie pagine e reindirizza gli utenti non loggati alla homepage
*/
Route::group(['middleware' => ['auth']], function () {

	// Definito fuori da un controller poichè non accede ad alcun dato
	Route::get('/utility', function(){return view('pages.utility');})->name('utility');

	Route::get('/calcolatrice-medica', 'PazienteController@showCalcolatriceMedica')->name('calcolatrice-medica');

	Route::get('/patient-summary', 'PazienteController@showPatientSummary')->name('patient-summary');

	Route::get('/taccuino', 'PazienteController@showTaccuino')->name('taccuino');

	Route::get('/careproviders', 'PazienteController@showCareProviders')->name('careproviders');

	Route::get('/files', 'PazienteController@showFiles')->name('files');

	Route::get('/impostazioniSicurezza', 'PazienteController@showSecuritySettings')->name('securitySettings');

});


Route::group( ['prefix' => 'fhir' ], function () {
        
        // Get a specific Patient Resource using ID
        Route::get('Patient/{id?}', 'Fhir\Modules\FHIRPatient@getResource');
        // Create a Patient by POSTing a Patient Resource
        Route::post('Patient', '\LibreEHR\FHIR\Http\Controllers\PatientController@post');
        // Update a Patient
        Route::put('Patient/{id}', '\LibreEHR\FHIR\Http\Controllers\PatientController@update');
        // Delete a Patient
        Route::delete('Patient/{id}', '\LibreEHR\FHIR\Http\Controllers\PatientController@destroy');
        Route::get('Appointments', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@showGroup');
        // Appointment?patient=1&date=lt2016-09-30&dat=gt2016-08-30 Gets all appointments for September 2016 where patient ID == 1
        // - if no patient is specified, we return the appointments of the current logged-in user
        Route::get('Appointment', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@index');
        // Create an Appointment by posting an Appointment Resource
        Route::post('Appointment', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@post');
        // Update an Appointment by PUTing an Appointment Resource
        Route::put('Appointment{id?}', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@put');
        // DELETE and appointment
        Route::delete('Appointment/{id}', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@destroy');
        // Get Slots for a provider Slot?provider=1&date=lt2020-09-30&date=gt2014-08-30
        Route::get('Slot/{slotDate?}', '\LibreEHR\FHIR\Http\Controllers\SlotController@index');
        // Post a Blundle of Resources to the base to create a bunch of resources
        Route::post('/', '\LibreEHR\FHIR\Http\Controllers\BundleController@store');
        // Get a ValueSet resource
        Route::get('ValueSet/{id}', '\LibreEHR\FHIR\Http\Controllers\ValuesetController@show');
    });
        
