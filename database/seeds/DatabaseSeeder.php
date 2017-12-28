<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TypesUsersTableSeeder::class);
        $this->call(StateSeeder::class);
		//Tabelle con dati statici
        $this->call(PatientsMarriageTableSeeder::class);
		$this->call(RolesTableSeeder::class);
		$this->call(DrugsCategoriesTableSeeder::class);
		//Fine tabelle dati statici
        $this->call(TownTableSeeder::class);
        //$this->call(UsersTableSeeder::class);
        //$this->call(ContactsTableSeeder::class);
        //$this->call(PatientsTableSeeder::class);
    }
}
