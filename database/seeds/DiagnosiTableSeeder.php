<?php

use Illuminate\Database\Seeder;

class DiagnosiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_diagnosi')->insert([
            ['id_diagnosi' => 1, 
             'id_paziente' => 2, 
             'diagnosi_confidenzialita' => 2, 
             'diagnosi_inserimento_data' => '2018-03-02',
             'diagnosi_aggiornamento_data' => '2018-03-02', 
             'diagnosi_patologia' => 'Influenza', 
             'diagnosi_stato' => 3, 
             'diagnosi_guarigione_data' => '2018-12-14']
        ]);
        
        
        DB::table('tbl_diagnosi')->insert([
            ['id_diagnosi' => 2,
                'id_paziente' => 2,
                'diagnosi_confidenzialita' => 3,
                'diagnosi_inserimento_data' => '2017-03-02',
                'diagnosi_aggiornamento_data' => '2017-03-02',
                'diagnosi_patologia' => 'Raffreddore',
                'diagnosi_stato' => 3,
                'diagnosi_guarigione_data' => '2017-12-14']
        ]);
        
        
        DB::table('tbl_diagnosi')->insert([
            ['id_diagnosi' => 3,
                'id_paziente' => 2,
                'diagnosi_confidenzialita' => 5,
                'diagnosi_inserimento_data' => '2016-03-02',
                'diagnosi_aggiornamento_data' => '2016-03-02',
                'diagnosi_patologia' => 'Mal di gola',
                'diagnosi_stato' => 1,
                'diagnosi_guarigione_data' => '2016-12-14']
        ]);
        
        
        DB::table('tbl_diagnosi')->insert([
            ['id_diagnosi' => 4,
                'id_paziente' => 2,
                'diagnosi_confidenzialita' => 4,
                'diagnosi_inserimento_data' => '2015-03-02',
                'diagnosi_aggiornamento_data' => '2015-03-02',
                'diagnosi_patologia' => 'Mal di testa',
                'diagnosi_stato' => 2,
                'diagnosi_guarigione_data' => '2015-12-14']
        ]);
    }
}
