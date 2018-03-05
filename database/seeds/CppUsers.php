<?php

use Illuminate\Database\Seeder;

class CppUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
public function run()
    {
        DB::table('tbl_care_provider')->insert([
            'id_cpp' => '1',
            'id_utente' => '1',
            'cpp_nome' => 'Bob',
            'cpp_cognome' => 'Kelso',
            'cpp_nascita_data' => '1995-01-01',
            'cpp_codfiscale' => 'BOBKLS95T91A554D',
            'cpp_sesso' => 'M',
            'cpp_n_iscrizione' => '00121331'
        ]);
    }
}
