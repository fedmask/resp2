<?php
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$this->call ( TypesUsersTableSeeder::class );
		$this->call ( StateSeeder::class );
		// Tabelle con dati statici
		$this->call ( PatientsMarriageTableSeeder::class );
		$this->call ( RolesTableSeeder::class );
		$this->call ( DrugsCategoriesTableSeeder::class );
		$this->call ( DrugsTableSeeder::class );
		$this->call ( DrugsVSTableSeeder::class );
		$this->call ( LevelConfTableSeeder::class );
		$this->call ( LoincAnswerListTableSeeder::class );
		$this->call ( LoincTableSeeder::class );
		$this->call ( LoincSlabValuesTableSeeder::class );
		$this->call ( ContactsTypesTableSeeder::class );
		// Fine tabelle dati statici
		$this->call ( UsersTableSeeder::class );
		$this->call ( PatientsTableSeeder::class );
		$this->call ( TownTableSeeder::class );
		$this->call ( ContactsTableSeeder::class );
		$this->call ( CppUsers::class );
		$this->call ( CareProviderPeopleTableSeeder::class );
		//$this->call ( MapsTableSeeder::class );
	}
}