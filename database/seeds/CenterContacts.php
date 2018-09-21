<?php

use Illuminate\Database\Seeder;

class CenterContacts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_centri_contatti')->insert([
            ['id_centro' => 1, 'id_modalita_contatto' => 1, 'contatto_valore' => "3895941244"],
            ['id_centro' => 1, 'id_modalita_contatto' => 2, 'contatto_valore' => "studiomio@nostro.it"],
        ]);
    }
}
