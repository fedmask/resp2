<?php

namespace Tests\Unit;


use Tests\TestCase;
use Auth;


class ExampleTest extends TestCase
{


    public function login($name,$password)
    {


        $response = $this->POST('/login', [
                'utente_nome'=>$name,
                'utente_password'=>$password]
        );

        $response->assertRedirect('/home');


    }



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


    //Test, log in as Janitor Jan and anamnesi


    public function testanamnesiPrint()
    {
        $this->login('Janitor Jan','test1234');

        $id = Auth::id()."\n";

        $response= $this->POST('/anamnesiprint');


        assert($id==2);

    }

}
