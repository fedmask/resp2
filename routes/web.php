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

//Route::post('patientRegister', 'Auth\PatientRegisterController@create')->name('patientRegister');    
Route::post('/register/patient', 'Auth\RegisterController@register');
$this->get('/register/patient', 'Auth\RegisterController@showRegistrationForm')->name('register');

/*Route::get('/register/patient', function(){
	//if(Auth::guest())
	//	return view('auth.register-patient');
    //else
	//	return redirect('/');
});
*/

Route::get('/register/careprovider', function(){
	if(Auth::guest())
		return view('auth.register-careprovider');
	else
		return redirect('/');
});

Route::get('/home', 'HomeController@index')->name('home');

/*
/ Reindirizza gli utenti non loggati alla homepage
*/
Route::get('/home', function() {
	if (Auth::guest())
		return redirect('/');
	else
		return view('home');
});

    
