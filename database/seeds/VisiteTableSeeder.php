<?php
use Illuminate\Database\Seeder;
class VisiteTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table ( 'tbl_pazienti_visite' )->insert ( [ 
				'id_cpp' => '1',
				'id_paziente' => '2',
				'visita_data' => '2018-02-02',
				'visita_motivazione' => 'Motivazione 1',
				'visita_osservazioni' => 'Osservazioni 1',
				'visita_conclusioni' => 'Conclusioni 1',
				'stato_visita' => 'booked',
				'codice_priorità' => '1',
				'richiesta'=>'required',
				'status'=>'accepted'
		] );
		
		DB::table ( 'tbl_pazienti_visite' )->insert ( [ 
				'id_cpp' => '1',
				'id_paziente' => '2',
				'visita_data' => '2018-03-03',
				'visita_motivazione' => 'Motivazione 2',
				'visita_osservazioni' => 'Osservazioni 2',
				'visita_conclusioni' => 'Conclusioni 2',
				'stato_visita' => 'arrived',
				'codice_priorità' => '2',
				'richiesta'=>'optional',
				'status'=>'declined'
		] );
	}
}
