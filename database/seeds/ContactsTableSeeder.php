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
        DB::table('tbl_recapiti')->insert([
            'id_contatto' => '1',
            'id_utente' => '1',
            'id_comune_residenza' => '2',
            'id_comune_nascita' => '2',
        ]);
    }
}
