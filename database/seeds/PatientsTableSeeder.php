<?php

use Illuminate\Database\Seeder;

class PatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
  
        DB::table('tbl_pazienti')->insert([
            'id_paziente' => '1',
            'id_utente' => '1',
            'paziente_nome' => 'Bob',
            'paziente_cognome' => 'Kelso',
            'paziente_nascita' => '1987-01-23',
            'paziente_codfiscale' => 'AHSTEG51T61AS522',
            'paziente_sesso' => 'male',
            'paziente_gruppo' => '0',
            'paziente_rh' => 'pos',
            'paziente_donatore_organi' => '1',

            'id_stato_matrimoniale' => 'A',

            'paziente_lingua' => 'it'
        ]);
        
        DB::table('tbl_pazienti')->insert([
            'id_utente' => '2',
            'paziente_nome' => 'Janitor',
            'paziente_cognome' => 'Jan',
            'paziente_nascita' => '1987-01-23',
            'paziente_codfiscale' => 'XASWEG51T61AS522',
            'paziente_sesso' => 'male',
            'paziente_gruppo' => '0',
            'paziente_rh' => 'neg',
            'paziente_donatore_organi' => '1',

            'id_stato_matrimoniale' => 'D',
            'paziente_lingua' => 'it'
        ]);
        
    }
}
