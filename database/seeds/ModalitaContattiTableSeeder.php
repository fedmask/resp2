<?php

use Illuminate\Database\Seeder;

class ModalitaContattiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_modalita_contatti')->insert([
            [   'id_modalita' => 1,
                'modalita_nome' => 'Telefono' 
            ]
        ]);
    }
}
