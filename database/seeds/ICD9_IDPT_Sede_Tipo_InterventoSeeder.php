<?php
use Illuminate\Database\Seeder;
class ICD9_IDPT_Sede_Tipo_Intervento extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table ( 'tbl_ICD9_IDPT_Sede_Tipo_Intervento' )->insert ( [ 
				[ 
						'IDPT_Sede' => '0',
						'IDPT_TipoIntervento' => '2',
						'descrizione' => 'TERAPIA AD ULTRASUONI' 
				] 
		] );
		//
	}
}
