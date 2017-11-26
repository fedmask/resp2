<?php

use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_pazienti_contatti')->insert([
            'id_paziente' => '1',
            'id_comune_residenza' => '2',
            'id_comune_nascita' => '2',
            'paziente_telefono' => '3895941255',
            'paziente_indirizzo' => 'via Roma',
        ]);
    }
}
