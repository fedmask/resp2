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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::post('patientRegister', 'Auth\PatientRegisterController@create')->name('patientRegister');    
Route::post('/register/patient', 'Auth\PatientRegisterController@store');
Route::get('/register/patient', function(){
	if(Auth::guest())
		return view('auth.register-patient');
	else
		return redirect('/');
});

Route::get('/register/careprovider', function(){
	if(Auth::guest())
		return view('auth.register-careprovider');
	else
		return redirect('/');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test_list', 'Pazienti@list');

/*
/ Reindirizza gli utenti non loggati alla homepage
*/
Route::get('/home', function() {
	if (Auth::guest())
		return redirect('/');
	else
		return view('home');
});

    
