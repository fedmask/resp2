<?php

use Illuminate\Database\Seeder;

class ImmunizationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_vaccinazione')->insert([
            'id_vaccinazione' => '1',
            'id_paziente' => '2',
            'vaccineCode' => '02',
            'vaccinazione_confidenzialita' => '3',
            'vaccinazione_data' => '2017-05-06',
            'vaccinazione_aggiornamento' => '2017-06-06',
            'vaccinazione_stato' => 'completed',
            'vaccinazione_notGiven' => '0',
            'vaccinazione_quantity' => '3',
            'vaccinazione_route' => 'PO',
            'vaccinazione_note'=> 'Vaccinazione terminata con successo',
            'vaccinazione_primarySource' => '1'
        ]);
        
        
        DB::table('tbl_vaccinazione')->insert([
            'id_vaccinazione' => '2',
            'id_paziente' => '2',
            'vaccineCode' => '06',
            'vaccinazione_confidenzialita' => '4',
            'vaccinazione_data' => '2018-02-03',
            'vaccinazione_aggiornamento' => '2018-04-03',
            'vaccinazione_stato' => 'entered-in-error',
            'vaccinazione_notGiven' => '1',
            'vaccinazione_quantity' => '5',
            'vaccinazione_route' => 'IM',
            'vaccinazione_note'=> 'Problema nella vaccinazione',
            'vaccinazione_primarySource' => '0'
        ]);
    }
}
