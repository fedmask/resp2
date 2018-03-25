<?php

use Illuminate\Database\Seeder;

class CppContactsCenter extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_modalita_contatti')->insert([
            ['id_modalita' => 1, 'modalita_nome' => 'Telefono'],
            ['id_modalita' => 2, 'modalita_nome' => 'Fisso'],
            ['id_modalita' => 3, 'modalita_nome' => 'Email'],
            ['id_modalita' => 4, 'modalita_nome' => 'Fax']
        ]);
    }
}
