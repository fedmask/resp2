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
            'persona_fax' => ''
        ]);
    }
}
