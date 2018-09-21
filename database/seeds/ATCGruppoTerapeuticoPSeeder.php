<?php

use Illuminate\Database\Seeder;

class ATCGruppoTerapeuticoPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table ( 'ATC_Gruppo_Terapeutico_P' )->insert ( [
            'Codice_Gruppo_Teraputico' => 'N05',
            'Codice_GTP' => '05',
            'Descrizione' => 'Psicolettici',
            'ID_Gruppo_Anatomico' => 'N' 
        ] );
    }
}
