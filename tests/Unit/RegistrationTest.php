<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    var $existingPatientId = 'Janitor Jan';
    var $existingPatientPassword = 'test1234';

    var $existingCareProviderId = 'Bob Kelso';
    var $existingCareProviderPassword = 'test1234';

    var $loggedUserRedirect = '/home';
    var $landingPage = '/';

    var $patientRegistrationUri = '/register/patient';
    var $patientRegistrationView = 'auth.register-patient';

    var $careProviderRegistrationUri = '/register/careprovider';
    var $careProviderRegistrationView = 'auth.register-careprovider';

    var $newPatientUsername = 'Tizio';
    var $newPatientEmail = 'ivanlamparelli@hotmail.it';
    var $newPatientPassword = 'test1234';
    var $newPatientSurname = 'Verdi';
    var $newPatientName = 'Stefano';
    var $newPatientSex = 'M';
    var $newPatientFiscalCode = 'VRDSFN80C30F205Z';



    public function testProva() {

        $this->assertTrue(true);

        $response = $this->POST('/register/patient', [


                'acceptInfo' => 'checked',
                'username' => 'Tizio',
                'name' => 'Stefano',
                'surname' => 'Verdi',
                'gender' => 'M',
                'CF' => 'vrdsfn80c30f205z',
                'email' => 'ivanlamparelli@hotmail.it',
                'confirmEmail' => 'ivanlamparelli@hotmail.it',
                'password' => 'test1234',
                'confirmPassword' => 'test1234',
                'birthCity' => 'Milano',
                'birthDate' => '30-03-1980',
                'livingCity' => 'Milano',
                'address' => 'via mazzini 10',
                'telephone' => '3331234567',
                'bloodType' => '3',
                'maritalStatus' => 'Divorziato',
                'shareData' => 'Y'

            ]
        );

        echo strtotime('30-03-1980');
        echo strtotime('now');

    }


    public function testRegisterPatient() {
        $response = $this->call('GET', $this->patientRegistrationUri);
        $response->assertViewIs($this->patientRegistrationView);

        $newPatient = [
          ''
        ];

        $response = $this->call('POST', $this->patientRegistrationUri);

    }


    public function testLoggedUserRegistrationRedirect() {

        //Checks redirect in case of logged-in patient
        $this->login($this->existingPatientId, $this->existingPatientPassword);
        $response = $this->call('GET', $this->patientRegistrationUri);
        $response->assertRedirect($this->loggedUserRedirect);

        //Checks redirect in case of logged-in care provider
        $this->login($this->existingCareProviderId, $this->existingCareProviderPassword);
        $response = $this->call('GET', $this->careProviderRegistrationUri);
        $response->assertRedirect($this->loggedUserRedirect);
    }
}
