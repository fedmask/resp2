<?php

use Illuminate\Database\Seeder;

class ATCSottogruppoChimicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table ( 'ATC_Sottogruppo_Chimico' )->insert ( [
            'Codice_ATC' => 'N05BA01',
            'Codice_Sottogruppo_CTF' => '01',
            'Descrizione' => 'Diazepam',
            'ID_Sottogruppo_CTF' => 'N05BA'
        ] );
        
        
        DB::table ( 'ATC_Sottogruppo_Chimico' )->insert ( [
            'Codice_ATC' => 'N05BA06',
            'Codice_Sottogruppo_CTF' => '06',
            'Descrizione' => 'Lorazepam',
            'ID_Sottogruppo_CTF' => 'N05BA'
        ] );
    }
}
