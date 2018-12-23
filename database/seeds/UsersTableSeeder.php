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
            'utente_email' => 'spanulis@hotmail.it',
            'utente_dati_condivisione' => '0',
            'utente_token_accesso' => ''
        ]);
		
		DB::table('tbl_utenti')->insert([
            'utente_nome' => 'Medico 118',
            'id_tipologia'=> '118',
            'utente_password' => bcrypt('test1234'),
            'utente_stato' => '1',
            'utente_scadenza' => '2030-01-01',
            'utente_email' => 'medico118s@hotmail.it',
            'utente_dati_condivisione' => '1',
            'utente_token_accesso' => ''
        ]);
        
        DB::table('tbl_utenti')->insert([
            'utente_nome' => 'Marco Kelso',
            'id_tipologia'=> 'mos',
            'utente_password' => bcrypt('test1234'),
            'utente_stato' => '0',
            'utente_scadenza' => '2030-01-01',
            'utente_email' => 'marco.kelso@paypal.com',
            'utente_dati_condivisione' => '0',
            'utente_token_accesso' => ''
        ]);
        
        
        DB::table('tbl_utenti')->insert([
        		'utente_nome' => 'Mario Rossi',
        		'id_tipologia'=> 'amm',
        		'utente_password' => bcrypt('test1234'),
        		'utente_stato' => '1',
        		'utente_scadenza' => '2030-01-01',
        		'utente_email' => 'privacy@fsem.com',
        		'utente_dati_condivisione' => '0',
        		'utente_token_accesso' => ''
        ]);
        
        DB::table('tbl_utenti')->insert([
        		'utente_nome' => 'Luca Rossi',
        		'id_tipologia'=> 'amm',
        		'utente_password' => bcrypt('test1234'),
        		'utente_stato' => '1',
        		'utente_scadenza' => '2030-01-01',
        		'utente_email' => 'administration@fsem.com',
        		'utente_dati_condivisione' => '0',
        		'utente_token_accesso' => ''
        ]);


    }
}
