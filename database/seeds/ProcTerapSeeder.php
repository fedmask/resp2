<?php

use Illuminate\Database\Seeder;

class ProcTerapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_proc_terapeutiche')->insert([
        		
            'descrizione' => 'Descrizione',
            'Data_Esecuzione'=>'2018-05-19',
            'Paziente'=> 1,
            'Diagnosi'=> 1,
            'CareProvider'=> 1,
            'Codice_icd9'=> '00.02'
            
        ]);
        
    }
}
