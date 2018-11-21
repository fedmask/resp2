<?php
use Illuminate\Database\Seeder;
class TrattamentiCareProviderSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table ( 'Trattamenti_CP' )->insert ( [ 
				[ 
						'Id_Trattamento' => 1,
						'Nome_T' => 'Messaggistica',
						'Finalita_T' => 'Conservazione dei messaggi scambiati con un Pazinete ',
						'Modalita_T' => 'Conservazione',
						'Informativa' => 'Acconsentendo i messaggi scambiati con un Paziente saranno conservati e crittografati per permettere la creazione di una chat con messaggi persistenti.',
						'Incaricati' => 'Care Provider, Paziente' 
				] 
		] );
		
		DB::table ( 'Trattamenti_CP' )->insert ( [ 
				[ 
						'Id_Trattamento' => 2,
						'Nome_T' => 'Assistenza Sanitaria',
						'Finalita_T' => 'Accesso alle proprie informazioni anagrafiche di base per la ricerca da parte di un Paziente',
						'Modalita_T' => 'Accesso',
						'Informativa' => 'Acconsentendo le informazioni di base che riguardano la sua persona quali il Nome, Cognome, Data di Nascita, Specializzazioni, ecc. saranno rese disponibili ai Pazienti per permettere loro la ricerca di un operatore sanitario',
						'Incaricati' => 'Pazienti' 
				] 
		] );
		
		DB::table ( 'Trattamenti_CP' )->insert ( [ 
				[ 
						
						'Id_Trattamento' => 3,
						'Nome_T' => 'Quality and Risk Managment ',
						'Finalita_T' => 'Accesso ai propri dati di audit al fine di garantire un servizio sicuro ed efficiente.',
						'Modalita_T' => 'Accesso in lettura',
						'Informativa' => 'Acconsentendo le informazioni di Audit saranno utilizzati processi interni di monitoramento dei servizi.',
						'Incaricati' => ' ' 
				] 
		] );
		
		DB::table ( 'Trattamenti_CP' )->insert ( [ 
				[ 
						'Id_Trattamento' => 4,
						'Nome_T' => 'Portabilità',
						'Finalita_T' => 'Accesso al servizio di portabilità dei propri dati personali.',
						'Modalita_T' => 'Accesso in lettura',
						'Informativa' => 'Acconsentendo i propri dati personali e sanitari saranno utilizzati dal sistema per generare i file xml del servizio "Portabilità"',
						'Incaricati' => 'CareProvider'
				] 
		] );
		
		
		DB::table ( 'Trattamenti_CP' )->insert ( [
				[
						'Id_Trattamento' => 5,
						'Nome_T' => 'Scientifica',
						'Finalita_T' => 'Utilizzo dei dati personali per indagini scientifiche.',
						'Modalita_T' => 'Accesso in lettura',
						'Informativa' => 'Acconsentendo i propri dati personali e sanitari saranno resi disponibili per indagini scientifiche interne all azienda',
						'Incaricati' => 'CareProvider'
				]
		] );
	}
}
