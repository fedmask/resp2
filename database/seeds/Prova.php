<?php

use Illuminate\Database\Seeder;

class Prova extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_utenti')->insert([
            'id_utente' => '4'
        ]);
        
        DB::table('tbl_recapiti')->insert([
            'id_utente' => '4',
            'id_comune_residenza' => '2',
            'id_comune_nascita' => '3',
        ]);
        
        DB::table ( 'tbl_care_provider' )->insert ( [
            'id_cpp' => '4',
            'id_utente' => '4',
            'cpp_nome' => 'Bobo',
            'cpp_cognome' => 'Vieri',
            'cpp_nascita_data' => '1995-01-01',
            'cpp_sesso' => 'male',
            'cpp_lingua' => 'it'
        ] );
        
        DB::table('CppQualification')->insert([
            'id_cpp' => '4',
            'Code' => 'DED'
        ]);
        
        DB::table('tbl_cpp_paziente')->insert([
            'id_cpp' => '4',
            'id_paziente' => '2',
            'assegnazione_confidenzialita' => '1'
        ]);
    }
}
