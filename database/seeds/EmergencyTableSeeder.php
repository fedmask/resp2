<?php

use Illuminate\Database\Seeder;

class EmergencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table ( 'tbl_emergency' )->insert ( [
            'id_emer' => '1',
            'id_utente' => '3',
            'emer_nome' => 'Medico',
            'emer_cognome' => '118',
            'emer_nascita_data' => '1995-01-01',
            'emer_codfiscale' => 'MED11895T91A554D',
            'emer_sesso' => 'male',
            'emer_n_iscrizione' => '00121399',
            'emer_localita_iscrizione' => "Barletta",
            'specializzation' => 'general_practice',
            'active' => '1',
            'emer_lingua' => 'it'
        ] );
    }
}
