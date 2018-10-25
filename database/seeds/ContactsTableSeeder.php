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
            'id_comune_nascita' => '3',
            'contatto_telefono' => '3895941255',
            'contatto_indirizzo' => 'via delle palme',
        ]);
        
        DB::table('tbl_recapiti')->insert([
            'id_contatto' => '2',
            'id_utente' => '2',
            'id_comune_residenza' => '12',
            'id_comune_nascita' => '33',
            'contatto_telefono' => '389485698',
            'contatto_indirizzo' => 'via delle bombe',
        ]);
        
        
        DB::table('tbl_recapiti')->insert([
            'id_contatto' => '3',
            'id_utente' => '3',
            'id_comune_residenza' => '11',
            'id_comune_nascita' => '34',
            'contatto_telefono' => '3333284123',
            'contatto_indirizzo' => 'via orabona',
        ]);
        
        DB::table('tbl_recapiti')->insert([
        		'id_contatto' => '4',
        		'id_utente' => '4',
        		'id_comune_residenza' => '767',
        		'id_comune_nascita' => '767',
        		'contatto_telefono' => '3386984521',
        		'contatto_indirizzo' => 'via Roma, 15',
        ]);
        
    }
}
