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
    }
}
