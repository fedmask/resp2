<?php

use Illuminate\Database\Seeder;

class ATCGruppoAnatomicoPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table ( 'tbl_Gruppo_Anatomico_P' )->insert ( [
            'ID_Gruppo_Anatomico' => 'N',
            'Descrizione' => 'Sistema Nervoso'
        ] );
        
    }
}
