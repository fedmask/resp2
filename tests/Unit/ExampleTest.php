<?php

namespace Tests\Unit;

use Collective\Html\FormBuilder;
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
}
