<?php

use Illuminate\Database\Seeder;

class ConsensoPazienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
    	
    	DB::table('Consenso_Paziente')->insert([
    			[   'Id_Trattamento' => '1',
    					'Id_Paziente' => '2',
    					'Consenso' => true,
    					'data_consenso'=> date('d-m-Y H:i:s'),
    			]
    	]);
    	
    	DB::table('Consenso_Paziente')->insert([
    			[   'Id_Trattamento' => '2',
    					'Id_Paziente' => '2',
    					'Consenso' => false,
    					'data_consenso'=> date('d-m-Y H:i:s'),
    			]
    	]);
    	
    	
    }
}
