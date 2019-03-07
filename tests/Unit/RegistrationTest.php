<?php

namespace Tests\Unit;

use App\Models\CurrentUser\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;

class RegistrationTest extends TestCase
{

    //use RefreshDatabase; //TODO scegli

    var $existingUserId = 'Janitor Jan';
    var $existingUserPassword = 'test1234';
    var $existingUserEmail = 'spanulis@hotmail.it';

    var $loggedUserRedirect = '/home';
    var $landingPage = '/';

    var $patientRegistrationUri = '/register/patient';
    var $patientRegistrationView = 'auth.register-patient';

    var $careProviderRegistrationUri = '/register/careprovider';
    var $careProviderRegistrationView = 'auth.register-careprovider';

    var $newPatient = [
        'username' => 'Tizio',
        'email' => 'tizio@gmail.com',
        'confirmEmail' => 'tizio@gmail.com',
        'password' => 'test1234',
        'confirmPassword' => 'test1234',
        'surname' => 'Verdi',
        'name' => 'Stefano',
        'gender' => 'male',
        'CF' => 'vrdsfn80c30f205z',
        'birthCity' => 'Milano',
        'birthDate' => '30-03-1980',
        'livingCity' => 'Milano',
        'address' => 'via mazzini 10',
        'telephone' => '3331234567',
        'bloodType' => 'A_POS',
        'maritalStatus' => 'D',
        'shareData' => 'Y',
        'acceptInfo' => 'on',
        'acceptCons' => 'on'
    ];

    var $newCareProvider = [
        'username' => 'Caio',
        'email' => 'caio@gmail.com',
        'confirmEmail' => 'caio@gmail.com',
        'password' => 'test1234',
        'confirmPassword' => 'test1234',
        'numOrdine' => '12345678',
        'registrationCity' => 'Taranto',
        'surname' => 'Bianchi',
        'name' => 'Luca',
        'gender' => 'male',
        'CF' => 'bnclcu85b28l049g',
        'birthCity' => 'Taranto',
        'birthDate' => '28-02-1985',
        'livingCity' => 'Taranto',
        'address' => 'via cesare battisti 40',
        'capSedePF' => '74121',
        'telephone' => '3123456789',
        'acceptInfo' => 'on'
    ];

    //TODO delete
    public function testProva()
    {
        $this->assertTrue(true);

    }

    public function testRegisterPatient() {

        //Visit patient registration view
        $response = $this->call('GET', $this->patientRegistrationUri);
        $response->assertViewIs($this->patientRegistrationView);

        //Send valid data via POST, register the user, go to /home
        $response = $this->call('POST', $this->patientRegistrationUri,$this->newPatient);
        $response->assertRedirect($this->loggedUserRedirect);
    }

    public function testRegisterCareProvider() {

        //Visit patient registration view
        $response = $this->call('GET', $this->careProviderRegistrationUri);
        $response->assertViewIs($this->careProviderRegistrationView);

        //Send valid data via POST, register the user, go to /home
        $response = $this->call('POST', $this->careProviderRegistrationUri,$this->newCareProvider);
        $response->assertRedirect($this->loggedUserRedirect);
    }

    public function testLoggedUserRedirect() {

        //Perform a login
        $this->login($this->existingUserId, $this->existingUserPassword);

        //Check redirect when visiting patient registration
        $response = $this->call('GET', $this->patientRegistrationUri);
        $response->assertRedirect($this->loggedUserRedirect);

        //Check redirect when visiting care-provider registration
        $response = $this->call('GET', $this->careProviderRegistrationUri);
        $response->assertRedirect($this->loggedUserRedirect);
    }
}
