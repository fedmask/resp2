<?php

use Illuminate\Database\Seeder;

class FamilyMemberHistoryConditionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('FamilyMemberHistoryCondition')->insert([
            'id_anamnesiF' => '1',
            'code' => '109006',
            'outcome' => '151004',
            'note' => '/'
        ]);
        
        DB::table('FamilyMemberHistoryCondition')->insert([
            'id_anamnesiF' => '2',
            'code' => '127009',
            'outcome' => '150003',
            'note' => '/'
        ]);
    }
}
