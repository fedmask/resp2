<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		/**
		* Popola il database con dati di prova.
	   */
        
        DB::table('tbl_utenti')->insert([
            'utente_nome' => 'Bob Kelso',
            'id_tipologia'=> 'mos',
            'utente_password' => bcrypt('test1234'),
            'utente_stato' => '1',
            'utente_scadenza' => '2030-01-01',
            'utente_email' => 'bobkelso@gmail.com',
        	
            'utente_dati_condivisione' => '1',
            'utente_token_accesso' => ''
        ]);

        DB::table('tbl_utenti')->insert([
            'utente_nome' => 'Janitor Jan',
            'id_tipologia'=> 'ass',
            'utente_password' => bcrypt('test1234'),
            'utente_stato' => '1',
            'utente_scadenza' => '2030-01-01',
            'utente_email' => 'janitorjan@gmail.com',
            'utente_dati_condivisione' => '0',
            'utente_token_accesso' => ''
        ]);
        
        DB::table('tbl_utenti')->insert([
            'utente_nome' => 'Zio paperone',
            'id_tipologia'=> 'ass',
            'utente_password' => bcrypt('test1234'),
            'utente_stato' => '0',
            'utente_scadenza' => '2030-01-01',
            'utente_email' => 'owner@paypal.com',
            'utente_dati_condivisione' => '0',
            'utente_token_accesso' => ''
        ]);


    }
}
