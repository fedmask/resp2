<?php

use Illuminate\Database\Seeder;

class ICD9_IntrventiChirurgici_ProcTerapeutiche extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	DB::table('Tbl_ICD9_IntrventiChirurgici_ProcTerapeutiche')->insert([
    			[   'id_IDPT_Organo' => '00',
    					'IDPT_Sede' => '0',
    					'IDPT_TipoIntervento' => '2',
    					'descrizione'=> 'TERAPIA AD ULTRASUONI DEL CUORE'
    			]
    	]);
        //
    }
}
