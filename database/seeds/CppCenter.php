<?php

use Illuminate\Database\Seeder;

class CppCenter extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_centri_indagini')->insert([
            ['id_centro' => 1, 'id_tipologia' => 1, 'id_comune' => 921, 'id_ccp_persona' => 1, 'centro_nome'=> 'A modo mio', 'centro_indirizzo' => 'via piave']
        ]);
    }
}
