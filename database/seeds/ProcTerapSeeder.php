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
            'Data_Esecuzione'=>'2018-05-19', //performed
            'Paziente'=> 1,
            'Diagnosi'=> 1,
            'CareProvider'=> 1,
            'Codice_icd9'=> '00.02',
            'Status' => 'preparation',
            'code'=> '104001',
            'reasonCode'=> '109006',
            'bodySite'=> '106004',
            'followUp'=> '18949003',
            'notDoneReason'=> '135809002',
            'complication'=> '109006',
            'Category'=>'409063005',
            'outCome'=>'385671000',
            'note'=> 'Note'
            
        ]);
        
    }
}
