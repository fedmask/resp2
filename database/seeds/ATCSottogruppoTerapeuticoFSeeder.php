<?php

use Illuminate\Database\Seeder;

class ATCSottogruppoTerapeuticoFSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table ( 'ATC_Sottogruppo_Terapeutico_F' )->insert ( [
            'id_sottogruppoTF' => 'N05B',
            'Codice_Gruppo_Teraputico' => 'B',
            'Descrizione' => 'Ansiolitici',
            'ID_Gruppo_Terapeutico' => 'N05'
        ] );
    }
}
