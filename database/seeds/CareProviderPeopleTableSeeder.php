<?php

use Illuminate\Database\Seeder;

class CareProviderPeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_cpp_persona')->insert([
            'id_utente' => '1',
            'id_comune' => '2',
            'persona_nome' => 'Bob',
            'persona_cognome' => 'Kelso',
            'persona_telefono' => '3895941255',
            'persona_fax' => '',
            'persona_reperibilita' => 'fittizio'
        ]);
        
        DB::table('tbl_cpp_persona')->insert([
            'id_utente' => '2',
            'id_comune' => '3',
            'persona_nome' => 'Giacomo',
            'persona_cognome' => 'Kelso',
            'persona_fax' => '',
            'persona_reperibilita' => 'ematologo'
        ]);
        
        DB::table('tbl_cpp_persona')->insert([
            'id_utente' => '3',
            'id_comune' => '4',
            'persona_nome' => 'Marco',
            'persona_cognome' => 'Kelso',
            'persona_fax' => '',
            'persona_reperibilita' => 'oncologo'
        ]);
        
    }
}
