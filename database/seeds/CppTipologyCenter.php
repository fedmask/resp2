<?php

use Illuminate\Database\Seeder;

class CppTipologyCenter extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_centri_tipologie')->insert([
            ['id_centro_tipologia' => 1, 'tipologia_nome' => "Studio specialistico"]
        ]);
    }
}
