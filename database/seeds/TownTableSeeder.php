<?php

use Illuminate\Database\Seeder;

class TownTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_comuni')->insert([
            'id_comune' => '1',
            'id_comune_nazione' => '1',
            'comune_nominativo' => 'Bari',
            'comune_cap' => '70100'
        ]);
        
        DB::table('tbl_comuni')->insert([
            'id_comune' => '2',
            'id_comune_nazione' => '1',
            'comune_nominativo' => 'Trani',
            'comune_cap' => '70123'
        ]);
    }
}
