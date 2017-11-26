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
        DB::table('tbl_nazioni')->insert([
            'id_nazione' => '1',
            'nazione_nominativo' => 'Italia',
            'nazione_prefisso_telefonico' => '+39'
        ]);
        
        DB::table('tbl_nazioni')->insert([
            'id_nazione' => '2',
            'nazione_nominativo' => 'Francia',
            'nazione_prefisso_telefonico' => '+37'
        ]);
        
        DB::table('tbl_nazioni')->insert([
            'id_nazione' => '3',
            'nazione_nominativo' => 'Spagna',
            'nazione_prefisso_telefonico' => '+34'
        ]);
        
        DB::table('tbl_comuni')->insert([
            'id_comune' => '1',
            'id_comune_nazione' => '1',
            'comune_nominativo' => 'Bari',
            'comune_cap' => '70100'
        ]);
        
        DB::table('tbl_comuni')->insert([
            'id_comune' => '2',
            'id_comune_nazione' => '1',
            'comune_nominativo' => 'Trani',
            'comune_cap' => '70123'
        ]);
        
        DB::table('tbl_pazienti_contatti')->insert([
            'id_paziente' => '1',
            'id_comune_residenza' => '2',
            'id_comune_nascita' => '2',
            'paziente_telefono' => '3895941255',
            'paziente_indirizzo' => 'via Roma',
        ]);
        
        DB::table('tbl_pazienti')->insert([
            'id_paziente' => '1',
            'id_utente' => '1',
            'id_paziente_contatti' => '1',
            'paziente_nome' => 'Bob',
            'paziente_cognome' => 'Kelso',
            'paziente_nascita' => '1987-01-23',
            'paziente_codfiscale' => 'AHSTEG51T61AS522',
            'paziente_sesso' => 'M',
            'paziente_gruppo' => '0',
            'paziente_rh' => 'pos',
            'paziente_donatore_organi' => '1',
            'paziente_stato_matrimoniale' => 'Sposato'
        ]);
        
    }
}
