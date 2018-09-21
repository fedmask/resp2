<?php

use Illuminate\Database\Seeder;

class ATCSottogruppoChimicoTFSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table ( 'ATC_Sottogruppo_Chimico_TF' )->insert ( [
            'id_sottogruppoCTF' => 'N05BA',
            'Codice_Sottogruppo_Teraputico' => 'A',
            'Descrizione' => 'Derivati Benzodiazepinici',
            'ID_Sottogruppo_Terapeutico' => 'N05B'
        ] );
    }
}
