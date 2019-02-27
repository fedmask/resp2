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



   public function registerPaziente($username,$name,$password)
    {

        $response = $this->POST('/register/patient', [


                'acceptInfo' => 'checked',
                'username' => $username,
                'name' => $name,
                'surname' => 'surname',
                'gender' => 'F',
                'CF' => 'AAAAAAAAAA',
                'email' => 'test@test.test',
                'confirmEmail' => 'test@test.test',
                'password' => $password,
                'confirmPassword' => $password,
                'birthCity' => 'Bari',
                'birthDate' => '25-07-1996',
                'livingCity' => 'Bari',
                'address' => 'Via Bari',
                'telephone' => '3030303030',
                'bloodType' => '0 negativo',
                'maritalStatus' => 'Poligamo',
                'shareData' => 'Y'

            ]
        );

        return $response;

    }



    public function registerCareProvider($username,$name,$password)
    {

        $response = $this->POST('/register/careprovider', [


                'acceptInfo' => 'cecked',
                'username' => $username,
                'email' => 'test@test.test',
                'confirmEmail' => 'test@test.test',
                'password' => $password,
                'confirmPassword' => $password,
                'numOrdine' => '1234',
                'registrationCity' => 'Bari',
                'surname' => 'Test',
                'name' => $name,
                'gender' => 'M',
                'CF' => 'AZAZAZ99X34A435A',
                'birthCity' => 'Bari',
                'birthDate' => '25-09-1996',
                'livingCity' => 'Bari',
                'address' => 'Via Bari',
                'cap' => '70127',
                'telephone' => '3039383736'

            ]
        );

        return $response;

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

    //Test, log in as Janitor Jan and anamnesi


    public function testan_amnesiPrint()
    {
        $this->login('Janitor Jan','test1234');

        $id = Auth::id()."\n";
        $response= $this->POST('/anamnesiprint');
        assert($id==2);

    }


    //Controller della registrazione presenta errori
    public function  test_registerPaziente(){

        echo "\nRegister as Patient: Test, Test"."\n"."\n";

        $response = $this->registerPaziente("Test","Test","test1234");

        echo "STATUS CODE: ".$response->getStatusCode();

        $response->assertStatus(302);

        echo "\nEND TEST"."\n"."\n";

    }

    //controller della registrazione presenta errori

    public function  test_registerCareProvider(){

        echo "\nRegister as Care Provider: Test, Test"."\n"."\n";

        $response = $this->registerPaziente("Test","Test","test1234");

        echo "STATUS CODE: ".$response->getStatusCode();

        $response->assertStatus(302);

        echo "\nEND TEST"."\n"."\n";

    }



}
