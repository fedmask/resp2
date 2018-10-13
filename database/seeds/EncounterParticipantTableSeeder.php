<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
            'start_period' => Carbon::now(new DateTimeZone('Europe/Rome')),
            'end_period' => Carbon::now(new DateTimeZone('Europe/Rome'))
        ]);
        
        DB::table('EncounterParticipant')->insert([
            'id_visita' => '1',
            'individual' => '2', //id_cpp
            'type' => 'ADM',
            'start_period' => Carbon::now(new DateTimeZone('Europe/Rome')),
            'end_period' => Carbon::now(new DateTimeZone('Europe/Rome'))
        ]);
        
        DB::table('EncounterParticipant')->insert([
            'id_visita' => '2',
            'individual' => '2', //id_cpp
            'type' => 'PART',
            'start_period' => Carbon::now(new DateTimeZone('Europe/Rome')),
            'end_period' => Carbon::now(new DateTimeZone('Europe/Rome'))
        ]);
    }
}
