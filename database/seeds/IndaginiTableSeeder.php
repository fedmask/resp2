<?php

use Illuminate\Database\Seeder;

class IndaginiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_indagini')->insert([
            [   'id_indagine' => 1,
                'id_centro_indagine' => 1,
                'id_diagnosi' => 1,
                'id_paziente' => 2,
                'id_cpp' => 1,
                'careprovider' => 'Bob Kelso',
                'indagine_data' => '2018-02-06',
                'indagine_aggiornamento' => '2018-04-03',
                'indagine_stato' => '1',
                'indagine_tipologia' => 'Tipologia indagine 1',
                'indagine_motivo' => 'Motivo indagine 1',
                'indagine_referto' => 'Referto indagine 1',
                'indagine_allegato' => 'Allegato indagine 1'
            ]
        ]);
        
        DB::table('tbl_indagini')->insert([
            [   'id_indagine' => 2,
                'id_centro_indagine' => 2,
                'id_diagnosi' => 2,
                'id_paziente' => 2,
                'id_cpp' => 2,
                'careprovider' => 'Giacomo Kelso',
                'indagine_data' => '2017-02-06',
                'indagine_aggiornamento' => '2017-04-03',
                'indagine_stato' => '2',
                'indagine_tipologia' => 'Tipologia indagine 2',
                'indagine_motivo' => 'Motivo indagine 2',
                'indagine_referto' => 'Referto indagine 2',
                'indagine_allegato' => 'Allegato indagine 2'
            ]
        ]);
        
        
        DB::table('tbl_indagini')->insert([
            [   'id_indagine' => 3,
                'id_centro_indagine' => 3,
                'id_diagnosi' => 3,
                'id_paziente' => 2,
                'id_cpp' => 3,
                'careprovider' => 'Marco Kelso',
                'indagine_data' => '2016-02-06 17:00:00',
                'indagine_aggiornamento' => '2016-04-03',
                'indagine_stato' => '0',
                'indagine_tipologia' => 'Tipologia indagine 3',
                'indagine_motivo' => 'Motivo indagine 3',
                'indagine_referto' => 'Referto indagine 3',
                'indagine_allegato' => 'Allegato indagine 3'
            ]
        ]);
        
        
        
    }
}
