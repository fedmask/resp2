<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Auth\LoginController;

class LoginTest extends TestCase
{
    var $validUserRedirect = '/home';
    var $invalidUserRedirect = '/';

    public function testValidPatientLogin() {

        $validPatientId = 'Janitor Jan';
        $validPatientPassword = 'test1234';
        $patientHomeView = 'pages.taccuino';

        $response = $this->login($validPatientId, $validPatientPassword);
        $response->assertRedirect($this->validUserRedirect);

        $response = $this->call('GET', $this->validUserRedirect);
        $response->assertViewIs($patientHomeView);
    }

    public function testValidCareProviderLogin() {

        $validCareProviderId = 'Bob kelso';
        $validCareProviderPassword = 'test1234';
        $careProviderControllerRedirect = '/patients-list';
        $careProviderHomeView = 'pages.careprovider.patients';

        $response = $this->login($validCareProviderId, $validCareProviderPassword);
        $response->assertRedirect($this->validUserRedirect);

        $response = $this->call('GET', $this->validUserRedirect);
        $response->assertRedirect($careProviderControllerRedirect);

        $response = $this->call('GET', $careProviderControllerRedirect);
        $response->assertViewIs($careProviderHomeView);
    }

    public function testWrongPasswordLogin() {

        $validPatientId = 'Janitor Jan';
        $invalidPatientPassword = 'wrongPassword';

        $response = $this->login($validPatientId, $invalidPatientPassword);
        $response->assertRedirect($this->invalidUserRedirect);
    }

    public function testInvalidUserLogin() {

        $invalidPatientId = 'wrongUser';
        $invalidPatientPassword = 'wrongPassword';

        $response = $this->login($invalidPatientId, $invalidPatientPassword);
        $response->assertRedirect($this->invalidUserRedirect);
    }

    public function login($username, $password)
    {

        $loginC = new LoginController();
        $usernameDbFieldName = $loginC->username(); //'utente_nome'
        $passwordDbFieldName = $loginC->password(); //'utente_password'

        $response = $this->call('POST', '/login', [
            $usernameDbFieldName => $username,
            $passwordDbFieldName => $password
        ]);

        return $response;
    }

}
