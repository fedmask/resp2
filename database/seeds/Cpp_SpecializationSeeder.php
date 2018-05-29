<?php

use Illuminate\Database\Seeder;

class Cpp_SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table ( 'tbl_cpp_specialization' )->insert ( [
            'id_specialization' => '1',
            'id_cpp' => '1',
            
        ] );
        
        DB::table ( 'tbl_cpp_specialization' )->insert ( [
            'id_specialization' => '2',
            'id_cpp' => '1',
            
        ] );
        
        DB::table ( 'tbl_cpp_specialization' )->insert ( [
            'id_specialization' => '1',
            'id_cpp' => '2',
            
        ] );
    }
}
