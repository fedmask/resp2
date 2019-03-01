<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Auth\LoginController;
use Auth;

class LoginTest extends TestCase
{
    var $validUserRedirect = '/home';
    var $landingPage = '/';

    public function testValidPatientLogin() {

        $validPatientId = 'Janitor Jan';
        $validPatientPassword = 'test1234';
        $patientHomeView = 'pages.taccuino';

        //Checks if the POST request redirects to /home
        $response = $this->login($validPatientId, $validPatientPassword);
        $response->assertRedirect($this->validUserRedirect);

        //Checks if the redirect to /home is handled by HomeController and sends to the patient home
        $response = $this->call('GET', $this->validUserRedirect);
        $response->assertViewIs($patientHomeView);

        //Checks the conditional content of the navbar in welcome.blade.php after the user is logged in
        $welcomeMessage = 'Ciao, '.Auth::user()->utente_nome;
        $response = $this->call('GET',$this->landingPage);
        $response->assertSeeText($welcomeMessage);
    }

    public function testValidCareProviderLogin() {

        $validCareProviderId = 'Bob kelso';
        $validCareProviderPassword = 'test1234';
        $careProviderControllerRedirect = '/patients-list';
        $careProviderHomeView = 'pages.careprovider.patients';

        //Checks if the POST request redirects to /home
        $response = $this->login($validCareProviderId, $validCareProviderPassword);
        $response->assertRedirect($this->validUserRedirect);

        //Checks if the redirect to /home is handled by HomeController and sends to /patients-list
        $response = $this->call('GET', $this->validUserRedirect);
        $response->assertRedirect($careProviderControllerRedirect);

        //Checks if the redirect /patients-list is handleded by CareProviderController and sends to the CP home
        $response = $this->call('GET', $careProviderControllerRedirect);
        $response->assertViewIs($careProviderHomeView);

        //Checks the conditional content of the navbar in welcome.blade.php after the user is logged in
        $welcomeMessage = 'Ciao, '.Auth::user()->utente_nome;
        $response = $this->call('GET',$this->landingPage);
        $response->assertSeeText($welcomeMessage);
    }

    public function testWrongPasswordLogin() {

        $validPatientId = 'Janitor Jan';
        $invalidPatientPassword = 'wrongPassword';

        //Checks if the POST request with invalid data redirects to /
        $response = $this->login($validPatientId, $invalidPatientPassword);
        $response->assertRedirect($this->landingPage);
    }

    public function testInvalidUserLogin() {

        $invalidPatientId = 'wrongUser';
        $invalidPatientPassword = 'wrongPassword';

        //Checks if the POST request with invalid data redirects to /
        $response = $this->login($invalidPatientId, $invalidPatientPassword);
        $response->assertRedirect($this->landingPage);
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
