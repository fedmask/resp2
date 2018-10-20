<?php

use Illuminate\Database\Seeder;

class TrattamentiCareProviderSeeder extends Seeder
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
    					'Nome_T' => 'Prova',
    					'Finalita_T' => 1,
    					'Modalita_T' => 1,
    					'Informativa' => 'Nome Centro 1',
    					'Incaricati' => 'Indirizzo Centro 1'
    			] ]);
    	
    	DB::table('Trattamenti_CP')->insert([
    			[ 'Id_Trattamento' => 2,
    					'Nome_T' => 'Prova1',
    					'Finalita_T' => 1,
    					'Modalita_T' => 1,
    					'Informativa' => 'Nome Centro 1',
    					'Incaricati' => 'Indirizzo Centro 1'
    			] ]);
    	
    	DB::table('Trattamenti_CP')->insert([
    			[ 'Id_Trattamento' => 3,
    					'Nome_T' => 'Prova2',
    					'Finalita_T' => 1,
    					'Modalita_T' => 1,
    					'Informativa' => 'Nome Centro 1',
    					'Incaricati' => 'Indirizzo Centro 1'
    			] ]);
    	
    	DB::table('Trattamenti_CP')->insert([
    			[ 'Id_Trattamento' => 4,
    					'Nome_T' => 'Prova3',
    					'Finalita_T' => 1,
    					'Modalita_T' => 1,
    					'Informativa' => 'Nome Centro 1',
    					'Incaricati' => 'Funziona'
    			] ]);
    	
        
    }
}
