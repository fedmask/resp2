<?php
use Illuminate\Database\Seeder;
class CppUsers extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table ( 'tbl_care_provider' )->insert ( [ 
				'id_cpp' => '1',
				'id_utente' => '1',
				'cpp_nome' => 'Bob',
				'cpp_cognome' => 'Kelso',
				'cpp_nascita_data' => '1995-01-01',
				'cpp_codfiscale' => 'BOBKLS95T91A554D',
				'cpp_sesso' => 'male',
				'cpp_n_iscrizione' => '00121331',
				'cpp_localita_iscrizione' => "Firenze",
				'specializzation' => 'general_practice',
		        'active' => '0',
		        'cpp_lingua' => 'it'
		] );
		
		DB::table ( 'tbl_care_provider' )->insert ( [ 
				'id_cpp' => '2',
				'id_utente' => '2',

				'cpp_nome' => 'Pippo',
				'cpp_cognome' => 'Kelso',
				'cpp_nascita_data' => '1996-01-01',
				'cpp_codfiscale' => 'PPPKLS96T91H501D',
				'cpp_sesso' => 'male',
				'cpp_n_iscrizione' => '00121332',
				'cpp_localita_iscrizione' => "Roma",
				'specializzation' => 'general_practice',
		        'active' => '0',
		        'cpp_lingua' => 'it'
		] );
		
		DB::table ( 'tbl_care_provider' )->insert ( [ 
				'id_cpp' => '3',
				'id_utente' => '4',
				'cpp_nome' => 'Marco',
				'cpp_cognome' => 'Kelso',
				'cpp_nascita_data' => '1997-01-01',
				'cpp_codfiscale' => 'MRCKLS97T91F205D',
				'cpp_sesso' => 'male',
				'cpp_n_iscrizione' => '00121333',
				'cpp_localita_iscrizione' => "Milano",
				'specializzation' => 'general_practice',
		        'active' => '0',
		        'cpp_lingua' => 'it'
		] );
	}
}
