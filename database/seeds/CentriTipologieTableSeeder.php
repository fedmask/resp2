<?php

use Illuminate\Database\Seeder;

class CentriTipologieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_centri_tipologie')->insert([
            [   'id_centro_tipologia' => 1,
                'tipologia_nome' => 'Studi Specialistici']
            ]);
        
        
        DB::table('tbl_centri_tipologie')->insert([
            [   'id_centro_tipologia' => 2,
                'tipologia_nome' => 'Studi Radiologici']
            ]);
        
        DB::table('tbl_centri_tipologie')->insert([
            [   'id_centro_tipologia' => 3,
                'tipologia_nome' => 'Laboratori Analisi']
            ]);
    }
}
