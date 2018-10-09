<?php

use Illuminate\Database\Seeder;

class ParenteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_Parente')->insert([
            'id_parente' => '1',
            'codice_fiscale' => '',
            'nome' => 'Tonio',
            'cognome' => 'Jan',
            'sesso' => 'male',
            'data_nascita' => '1990-01-01',
            'eta' => '',
            'decesso' => '',
            'eta_decesso' => '',
            'data_decesso' => '',
        ]);
        
        
        DB::table('tbl_Parente')->insert([
            'id_parente' => '2',
            'codice_fiscale' => '',
            'nome' => 'Marika',
            'cognome' => 'Key',
            'sesso' => 'female',
            'data_nascita' => '1890-04-03',
            'eta' => '',
            'decesso' => '',
            'eta_decesso' => '',
            'data_decesso' => '',
        ]);
    }
}
