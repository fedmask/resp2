<?php

use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_nazioni')->insert([
            'id_nazione' => '1',
            'nazione_nominativo' => 'Italia',
            'nazione_prefisso_telefonico' => '+39'
        ]);
        
        DB::table('tbl_nazioni')->insert([
            'id_nazione' => '2',
            'nazione_nominativo' => 'Francia',
            'nazione_prefisso_telefonico' => '+37'
        ]);
        
        DB::table('tbl_nazioni')->insert([
            'id_nazione' => '3',
            'nazione_nominativo' => 'Spagna',
            'nazione_prefisso_telefonico' => '+34'
        ]);
    }
}
