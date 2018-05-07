<?php

use Illuminate\Database\Seeder;

class ConfidenzialitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('tbl_cpp_paziente')->insert([
    			'id_cpp' => '2',
    			'id_paziente' => '2',
    			'assegnazione_confidenzialita' => '3',
    	]);
    	
    	DB::table('tbl_cpp_paziente')->insert([
    	    'id_cpp' => '1',
    	    'id_paziente' => '1',
    	    'assegnazione_confidenzialita' => '3',
    	]);
    }
}
