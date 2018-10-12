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
            'role' => 'CP'
        ]);
        
        DB::table('ImmunizationProvider')->insert([
            'id_cpp' => '2',
            'role' => 'OP'
        ]);
    }
}
