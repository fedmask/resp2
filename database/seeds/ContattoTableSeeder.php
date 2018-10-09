<?php

use Illuminate\Database\Seeder;

class ContattoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Contatto')->insert([
            'id_contatto' => '1',
            'id_paziente' => '2',
            'attivo' => '0',
            'relazione' => 'E',
            'nome' => 'Michele',
            'cognome' => 'Rossi',
            'sesso' => 'male',
            'telefono' => '00058895',
            'mail' => 'michele.rossi@gmail.com',
            'data_nascita' => '1990-01-01',
            'data_inizio' => '2000-10-10',
            'data_fine' => '2020-10-10'
        ]);
        
        
        DB::table('Contatto')->insert([
            'id_contatto' => '2',
            'id_paziente' => '2',
            'attivo' => '0',
            'relazione' => 'EP',
            'nome' => 'Micaela',
            'cognome' => 'Putin',
            'sesso' => 'female',
            'telefono' => '00058895',
            'mail' => 'micaela.putin@gmail.com',
            'data_nascita' => '1985-01-01',
            'data_inizio' => '2000-02-03',
            'data_fine' => '2015-03-11'
        ]);
    }
}
