<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Http\Controllers\Auth\LoginController;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Logs the user in the system, for tests that require users to be logged-in
     * @param $username
     * @param $password
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function login($username, $password)
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
