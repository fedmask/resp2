<?php

use Illuminate\Database\Seeder;

class TrattamentiPazienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
        DB::table('Trattamenti_Pazienti')->insert([
            [ 'Id_Trattamento' => 1,
                'Nome_T' => 1,
                'Finalita_T' => 1,
                'Modalita_T' => 1,
                'Informativa' => 'Nome Centro 1',
                'Incaricati' => 'Indirizzo Centro 1'
       ] ]);

        
       DB::table('Trattamenti_Pazienti')->insert([
        		[ 'Id_Trattamento' => 2,
        				'Nome_T' => 'Prova funzionamento',
        				'Finalita_T' => 1,
        				'Modalita_T' => 1,
        				'Informativa' => 'Prova 2',
        				'Incaricati' => 'Indirizzo Centro 1'
        		] ]);
    }
}
