<?php

use Illuminate\Database\Seeder;

class PatientContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
    DB::table('PatientContact')->insert([
        'Id_Patient' => '1',
        'Relationship' => 'EP',
        'Name' => 'Giacomo',
        'Surname' => 'Rossi',
        'Telephone' => '23656565',
        'Mail' => 'giacomo.rossi@libero.it'
    ]);
    
    
    DB::table('PatientContact')->insert([
        'Id_Patient' => '2',
        'Relationship' => 'E',
        'Name' => 'Giacomo',
        'Surname' => 'Jan',
        'Telephone' => '523689965',
        'Mail' => 'giacomo.jan@libero.it'
    ]);
    
    
    DB::table('PatientContact')->insert([
        'Id_Patient' => '2',
        'Relationship' => 'BP',
        'Name' => 'Anita',
        'Surname' => 'Rossi',
        'Telephone' => '6456466',
        'Mail' => 'anita.rossi@libero.it'
    ]);
}
}
