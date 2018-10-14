<?php

use Illuminate\Database\Seeder;

class FamilyMemberHistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_AnamnesiF')->insert([
            'id_anamnesiF' => '1',
            'descrizione' => 'descrizione1',
            'id_paziente' => '2',
            'id_parente' => '1',
            'status' => 'completed',
            'notDoneReason' => '',
            'note' => 'note1',
            'data' => '2018-05-07'
        ]);
        
        DB::table('tbl_AnamnesiF')->insert([
            'id_anamnesiF' => '2',
            'descrizione' => 'descrizione2',
            'id_paziente' => '2',
            'id_parente' => '2',
            'status' => 'partial',
            'notDoneReason' => '',
            'note' => 'note2',
            'data' => '2016-06-06'
        ]);
    }
}
