<?php

use Illuminate\Database\Seeder;

class ImmunizationProviderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('ImmunizationProvider')->insert([
            'id_cpp' => '1',
            'role' => 'AP',
            'id_vaccinazione' => '1'
        ]);
        
        DB::table('ImmunizationProvider')->insert([
            'id_cpp' => '2',
            'role' => 'OP',
            'id_vaccinazione' => '1'
        ]);
        
        DB::table('ImmunizationProvider')->insert([
            'id_cpp' => '2',
            'role' => 'AP',
            'id_vaccinazione' => '2'
        ]);
    }
}
