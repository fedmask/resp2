<?php

namespace Tests\Unit;

use Tests\TestCase;
use Auth;

class LoginTest extends TestCase
{
    var $validPatientId = 'Janitor Jan';
    var $validPatientPassword = 'test1234';
    var $patientHomeView = 'pages.taccuino';

    var $validCareProviderId = 'Bob Kelso';
    var $validCareProviderPassword = 'test1234';
    var $careProviderControllerRedirect = '/patients-list';
    var $careProviderHomeView = 'pages.careprovider.patients';

    var $invalidPatientId = 'wrongUser';
    var $invalidPatientPassword = 'wrongPassword';

    var $validUserRedirect = '/home';
    var $landingPage = '/';
    var $logoutRedirect = '/logout';

    /**
     * Checks if the login succeeds with valid patient credentials
     */
    public function testValidPatientLogin() {

        //Checks if the POST request redirects to /home
        $response = $this->login($this->validPatientId, $this->validPatientPassword);
        $response->assertRedirect($this->validUserRedirect);

        //Checks if the redirect to /home is handled by HomeController and sends to the patient home
        $response = $this->call('GET', $this->validUserRedirect);
        $response->assertViewIs($this->patientHomeView);

        //Checks the conditional content of the navbar in welcome.blade.php after the user is logged in
        $welcomeMessage = 'Ciao, '.Auth::user()->utente_nome;
        $response = $this->call('GET',$this->landingPage);
        $response->assertSeeText($welcomeMessage);
    }

    /**
     * Checks if the login succeds with valide careprovider credentials
     */
    public function testValidCareProviderLogin() {

        //Checks if the POST request redirects to /home
        $response = $this->login($this->validCareProviderId, $this->validCareProviderPassword);
        $response->assertRedirect($this->validUserRedirect);

        //Checks if the redirect to /home is handled by HomeController and sends to /patients-list
        $response = $this->call('GET', $this->validUserRedirect);
        $response->assertRedirect($this->careProviderControllerRedirect);

        //Checks if the redirect /patients-list is handled by CareProviderController and sends to the CP home
        $response = $this->call('GET', $this->careProviderControllerRedirect);
        $response->assertViewIs($this->careProviderHomeView);

        //Checks the conditional content of the navbar in welcome.blade.php after the user is logged in
        $welcomeMessage = 'Ciao, '.Auth::user()->utente_nome;
        $response = $this->call('GET',$this->landingPage);
        $response->assertSeeText($welcomeMessage);
    }

    /**
     * Checks if the login redirects to the landing page if you insert the wrong password
     */
    public function testWrongPasswordLogin() {

        //Checks if the POST request with invalid data redirects to /
        $response = $this->login($this->validPatientId, $this->invalidPatientPassword);
        $response->assertRedirect($this->landingPage);
    }

    /**
     * Checks if the login redirects to the landing page if you insert a non-existing user
     */
    public function testInvalidUserLogin() {

        //Checks if the POST request with invalid data redirects to /
        $response = $this->login($this->invalidPatientId, $this->invalidPatientPassword);
        $response->assertRedirect($this->landingPage);
    }

    /**
     * Checks if the logout correctly erases the user session and redirects to the landing page
     */
    public function testLogout() {

        $this->login($this->validPatientId, $this->validPatientPassword);

        $response = $this->call('POST', $this->logoutRedirect);

        //Checks if the current user is a "guest" (a user that isn't logged-in)
        $this->assertTrue(Auth::guest());

        $response->assertRedirect($this->landingPage);


    }

}
