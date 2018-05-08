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
            'cpp_n_iscrizione' => '00121331',
            'cpp_localita_iscrizione'=>"Firenze"
        ]);
        
        DB::table('tbl_care_provider')->insert([
            'id_cpp' => '2',
            'id_utente' => '2',
            'cpp_nome' => 'Giacomo',
            'cpp_cognome' => 'Kelso',
            'cpp_nascita_data' => '1996-01-01',
            'cpp_codfiscale' => 'BOBKLS96T91H501D',
            'cpp_sesso' => 'M',
            'cpp_n_iscrizione' => '00121332',
            'cpp_localita_iscrizione'=>"Roma"
        ]);
        
        DB::table('tbl_care_provider')->insert([
            'id_cpp' => '3',
            'id_utente' => '3',
            'cpp_nome' => 'Marco',
            'cpp_cognome' => 'Kelso',
            'cpp_nascita_data' => '1997-01-01',
            'cpp_codfiscale' => 'BOBKLS97T91F205D',
            'cpp_sesso' => 'M',
            'cpp_n_iscrizione' => '00121333',
            'cpp_localita_iscrizione'=>"Milano"
        ]);
    }
}

