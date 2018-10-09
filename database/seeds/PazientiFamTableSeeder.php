<?php

use Illuminate\Database\Seeder;

class PazientiFamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_pazienti_familiarita')->insert([
            'id_paziente' => '2',
            'id_parente' => '1',
            'relazione' => 'BRO',
            'familiarita_grado_parentela' => '',
            'familiarita_aggiornamento_data' => '',
            'familiarita_conferma' => ''
        ]);
        
        DB::table('tbl_pazienti_familiarita')->insert([
            'id_paziente' => '2',
            'id_parente' => '2',
            'relazione' => 'COUSN',
            'familiarita_grado_parentela' => '',
            'familiarita_aggiornamento_data' => '',
            'familiarita_conferma' => ''
        ]);
    }
}
