<?php

namespace Tests\Unit;


use App\Http\Controllers\AnamnesiController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Redirect;
use Tests\TestCase;
use Auth;


class ExampleTest extends TestCase
{
   static $num_test=1;



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
    public function test_Show_RegisterView()
    {
        echo "\n************** TEST REGISTER VIEW **************\n\n";


        $response = $this->json('GET', '/register/patient');

        if($response ->assertViewIs('auth.register-patient')){
            echo "   VIEW CREATED - TEST PASSED\n";
        }



        echo "\n************** END TEST ".self::$num_test++." **************\n\n";


    }

    //Test, log in as Janitor Jan and anamnesi


    public function test_login_paziente()
    {
        echo "\n************** TEST LOGIN AS PAZIENTE **************\n\n";
        echo "\nLogin as: Username= 'Janitor Jan' Password= 'test1234'\"\n\n";

        $response=$this->login('Janitor Jan','test1234');

        $response->assertRedirect('/home');

        echo "\n************** END TEST ".self::$num_test++." **************\n\n";

    }


    public function test_login_cp()
    {
        echo "\n************** TEST LOGIN AS CARE PROVIDER **************\n";
        echo "\nLogin as: Username= 'Bob Kelso' Password= 'test1234'\"\n";

        $response=$this->login('Bob Kelso','test1234');

        $response->assertRedirect('/home');

        echo "\n************** END TEST ".self::$num_test++." **************\n\n";

    }


    //Controller della registrazione presenta errori
    public function  test_registerPaziente(){

        echo "\n************** TEST REGISTER AS PATIENT **************\n";

        echo "\nRegister as Name: 'Test' Username: 'Test' Password: 'test1234'\n\n";


        $response = $this->registerPaziente("Test","Test","test1234");


        assert(RegisterController::$forTest_boolean==true,"IMPLEMENTARE CORRETTAMENTE FUNZIONE DI REGISTRAZIONE");

        $response->assertRedirect('/');

        echo "\n************** END TEST ".self::$num_test++." **************\n\n";

    }

    //controller della registrazione presenta errori

    public function  test_registerCP(){

        echo "\n************** TEST REGISTER AS CARE PROVIDER **************\n\n";

        echo "\nRegister as Name: 'Test' Username: 'Test' Password: 'test1234'\"\n\n";

        $response = $this->registerCareProvider("Test","Test","test1234");

        assert(RegisterController::$forTest_boolean==true,"IMPLEMENTARE CORRETTAMENTE FUNZIONE DI REGISTRAZIONE");

        $response->assertRedirect('/');
        echo "\n************** END TEST ".self::$num_test++." **************\n\n";

    }



    public function test_addVisita_familiare(){


        echo "\n************** TEST ADD VISIT (ANAMNESI FAMILIARE)**************\n\n";

        echo "\nLogin as: Username= 'Janitor Jan' Password= 'test1234'\"\n\n";


        $this->login("Janitor Jan","test1234");

        $response=$this->POST('/anamnesi',[

            'input_name'=>'Familiare',
            'testofam'=>'Questa è un anamnesi di Test'

            ]
        );

        assert(AnamnesiController::$forTest_boolean==true,"IMPOSSIBILE AGGIUNGERE VISITA");

        $response->assertRedirect('/anamnesi');

        echo "\n************** END TEST ".self::$num_test++." **************\n\n";


    }

    public function test_addVisita(){


        echo "\n************** TEST ADD VISIT (ANAMNESI PARENTE)**************\n\n";


        $this->login("Janitor Jan","test1234");

        $response=$this->POST('/anamnesi',[

                'input_name'=>'Parente',

            ]
        );

        assert(AnamnesiController::$forTest_boolean==true,"IMPOSSIBILE AGGIUNGERE VISITA");

        $response->assertRedirect('/anamnesi');

        echo "\n************** END TEST ".self::$num_test++." **************\n\n";


    }


}
