<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ConditionSeverity;

class AmministrativeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('Utenti_Amministrativi')->insert([
    			'id_utente' => '4',
    			'Nome'=>'Mario',
    			'Cognome'=>'Rossi',
    			'Ruolo'=> 'Personale di Supporto',
    			'Sesso'=>'M',
    			'Data_Nascita'=>'1956-08-02',
    			'Comune_Nascita'=>'767',
    			'Comune_Residenza'=>'767',
    			'Indirizzo'=>'via Roma, 15',
    			'Recapito_Telefonico'=>'3386984521'
    	]);
    	
    	DB::table('Utenti_Amministrativi')->insert([
    			'id_utente' => '5',
    			'Nome'=>'Luca',
    			'Cognome'=>'Rossi',
    			'Ruolo'=> 'Amministratore_di_sistema',
    			'Sesso'=>'M',
    			'Data_Nascita'=>'1956-08-02',
    			'Comune_Nascita'=>'767',
    			'Comune_Residenza'=>'767',
    			'Indirizzo'=>'via Roma, 15',
    			'Recapito_Telefonico'=>'3386984521'
    	]);
        
    }
}
