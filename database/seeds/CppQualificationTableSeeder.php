<?php

use Illuminate\Database\Seeder;

class CppQualificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('CppQualification')->insert([
            'id_cpp' => '1',
            'Code' => 'DED',
            'Start_Period' => '2015-03-09',
            'End_Period' => '2025-03-09',
            'Issuer' => 'University'
        ]);
        
        DB::table('CppQualification')->insert([
            'id_cpp' => '2',
            'Code' => 'CRN',
            'Start_Period' => '2016-01-02',
            'End_Period' => '2026-01-02',
            'Issuer' => 'University'
        ]);
        
        
        DB::table('CppQualification')->insert([
            'id_cpp' => '3',
            'Code' => 'EMT',
            'Start_Period' => '2017-11-11',
            'End_Period' => '2027-11-11',
            'Issuer' => 'University'
        ]);
        
    }
}
