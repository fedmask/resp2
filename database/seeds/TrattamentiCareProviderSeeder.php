<?php

use Illuminate\Database\Seeder;

class CentriIndaginiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('Trattamenti_CP')->insert([
    			[ 'Id_Trattamento' => 1,
    					'Nome_T' => 1,
    					'Finalita_T' => 1,
    					'Modalita_T' => 1,
    					'Informativa' => 'Nome Centro 1',
    					'Incaricati' => 'Indirizzo Centro 1'
    			] ]);
        
    }
}
