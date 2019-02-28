<?php

namespace Tests\Unit;


use Tests\TestCase;
use Auth;


class ExampleTest extends TestCase
{
   static $num_test=0;



    public function login($name,$password)
    {


        $response = $this->POST('/login', [
                'utente_nome'=>$name,
                'utente_password'=>$password]
        );


        return $response;

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
    public function test_RegisterView()
    {
        echo "\nTEST REGISTER VIEW\n\n";


        $response = $this->json('GET', '/register/patient');
        $response ->assertViewIs('auth.register-patient');

        echo "\nEND TEST ".self::$num_test++."\n\n";


    }

    //Test, log in as Janitor Jan and anamnesi


    public function test_login_paziente()
    {
        echo "\nTEST LOGIN AS PAZIENTE\n\n";
        $response=$this->login('Janitor Jan','test1234');

        $response->assertRedirect('/home');

        echo "\nEND TEST ".self::$num_test++."\n\n";

    }


    public function test_login_cp()
    {
        echo "\nTEST LOGIN AS CARE PROVIDER\n\n";
        $response=$this->login('Bob Kelso','test1234');

        $response->assertRedirect('/home');

        echo "\nEND TEST ".self::$num_test++."\n\n";

    }


    //Controller della registrazione presenta errori
    public function  test_registerPaziente(){

        echo "\nTEST LOGIN AS PATIENT\n\n";

        $response = $this->registerPaziente("Test","Test","test1234");

        echo "STATUS CODE: ".$response->getStatusCode();

        $response->assertRedirect('/');

        echo "\nEND TEST ".self::$num_test++."\n\n";

    }

    //controller della registrazione presenta errori

    public function  test_registerCP(){

        echo "\nTEST LOGIN AS CARE PROVIDER\n\n";

        $response = $this->registerPaziente("Test","Test","test1234");

        echo "STATUS CODE: ".$response->getStatusCode();

        $response->assertRedirect('/');
        echo "\nEND TEST ".self::$num_test++."\n\n";

    }



    public function test_addVisita(){


        echo "\nTEST ADD VISIT\n\n";


        $this->login("Janitor Jan","test1234");

        $response=$this->POST('/visite/addVisita',[

            'add_visita_data' => 'r25/07/2020',
            'add_visita_motivazione' => 'Test',
            'add_visita_osservazioni' =>'Test',
            'add_visita_conclusioni' =>'Test',
            'add_parametro_altezza'=>'190',
            'add_parametro_peso'=>'90',
            'add_parametro_pressione_minima'=>'120',
            'add_parametro_pressione_massima'=>'125',
            'add_parametro_frequenza_cardiaca'=>'75'

        ]);

        $response->assertRedirect('/');

       echo "\nEND TEST ".self::$num_test++."\n\n";


    }




}
