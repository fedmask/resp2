<?php

use Illuminate\Database\Seeder;

class EncounterParticipantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('EncounterParticipant')->insert([
            'id_visita' => '1',
            'individual' => '1', //id_cpp
            'type' => 'PART',
            'start_period' => '2016-06-02',
            'end_period' => '2016-06-02'
        ]);
        
        DB::table('EncounterParticipant')->insert([
            'id_visita' => '1',
            'individual' => '2', //id_cpp
            'type' => 'ADM',
            'start_period' => '2016-06-02',
            'end_period' => '2016-06-02'
        ]);
        
        DB::table('EncounterParticipant')->insert([
            'id_visita' => '2',
            'individual' => '2', //id_cpp
            'type' => 'PART',
            'start_period' => '2018-05-05',
            'end_period' => '2018-05-05'
        ]);
    }
}
