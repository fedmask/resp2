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
		
        DB::table('users')->insert([
	            'name' => 'Bob Kelso',
	            'email' => 'bobkelso@gmail.com',
	            'password' => bcrypt('test1234'),
				'role' => 'care_provider'
	        ]);
		
		DB::table('users')->insert([
	            'name' => 'Janitor Jan',
	            'email' => 'janitorjan@gmail.com',
	            'password' => bcrypt('test1234'),
				'role' => 'paziente'
	        ]);
	   */
        
        DB::table('tbl_utenti')->insert([
            'utente_nome' => 'Bob Kelso',
            'utente_password' => bcrypt('test1234'),
            'utente_stato' => '1',
            'utente_scadenza' => '2030-01-01',
            'utente_email' => 'bobkelso@gmail.com',
            'utente_tipologia' => '1'
        ]);
        
        DB::table('tbl_utenti')->insert([
            'utente_nome' => 'Janitor Jan',
            'utente_password' => bcrypt('test1234'),
            'utente_stato' => '1',
            'utente_scadenza' => '2030-01-01',
            'utente_email' => 'janitorjan@gmail.com',
            'utente_tipologia' => '2'
        ]);
        
        DB::table('tbl_utenti')->insert([
            'utente_nome' => 'Zio paperone',
            'utente_password' => bcrypt('test1234'),
            'utente_stato' => '0',
            'utente_scadenza' => '2030-01-01',
            'utente_email' => 'owner@paypal.com',
            'utente_tipologia' => '1'
        ]);

    }
}
