<?php

use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table ( 'tbl_specialization' )->insert ( [
            'desc_specialization' => 'General practice'
            
        ] );
        
        
        DB::table ( 'tbl_specialization' )->insert ( [
            'desc_specialization' => 'General medicine'
            
        ] );
        
        
        DB::table ( 'tbl_specialization' )->insert ( [
            'desc_specialization' => 'Endocrinology'
        ] );
    }
}
