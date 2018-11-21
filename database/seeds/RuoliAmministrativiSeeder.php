<?php
use Illuminate\Database\Seeder;
class RuoliAmministrativiSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table ( 'Ruoli_amministratori' )->insert ( [ 
				'Ruolo' => 'DPO'
	] );
		DB::table ( 'Ruoli_amministratori' )->insert ( [
				'Ruolo' => 'Responsabile al Trattamento'
		] );
		DB::table ( 'Ruoli_amministratori' )->insert ( [
				'Ruolo' => 'Amministratore_di_sistema'
		] );
		DB::table ( 'Ruoli_amministratori' )->insert ( [
				'Ruolo' => 'Personale di Supporto'
		] );
		
		
		
	}
}
