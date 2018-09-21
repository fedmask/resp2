<?php

use Illuminate\Database\Seeder;

class ICD9_IntrventiChirurgici_ProcTerapeuticheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Tbl_ICD9_ICPT')->insert([
            [   'Codice_ICD9' => '00.02',
                'IDPT_Organo' => '00',
                'IDPT_ST' => '02',
                'Descizione_ICD9'=> 'TERAPIA AD ULTRASUONI DEL CUORE'
            ]
        ]);
        
    }
}
