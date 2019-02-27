<?php

namespace Tests\Unit;

use Collective\Html\FormBuilder;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {



        $response = $this->json('GET', '/register/patient');
        $response ->assertViewIs('auth.register-patient');



    }


    public function testAnamnesi()
    {


        $response = $this->json('POST', '/anamnesi');
        //$response ->assertViewIs('auth.register-patient');
        $response->assertRedirect('/anamnesi');



    }


    public function testLogin() 
    {


        $response = $this->json('POST','/login', [
            'utente_nome'=>'Janitor Jan',
            'utente_password'=>'test1234']
        );




        $response->assertRedirect('/home');
    }



}
