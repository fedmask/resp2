<?php

use Illuminate\Database\Seeder;

class ICD9_IDPT_Sede_Tipo_InterventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table ( 'tbl_ICD9_IDPT_ST' )->insert ( [
            [
                'id_IDPT_ST' => '02',
                'descrizione_sede' => '""',
                'descrizione_tipo_intervento' => 'TERAPIA AD ULTRASUONI'
                
            ]
        ] );
        
    }
}
