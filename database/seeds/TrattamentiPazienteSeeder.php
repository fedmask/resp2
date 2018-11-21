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
                'Nome_T' => 'Consultazione',
                'Finalita_T' => 'Accesso delle informazioni personali e sanitarie da parte dei Care Provider selezionati',
                'Modalita_T' => 'Accesso in lettura.',
                'Informativa' => 'Acconsenendo si dichiara la volonta alla consultazone dei propri dati personali e sanitari da parte dei Care Provider selezionati. Il consenso a tale trattamento è obbligatorio per poter accedere ai nostri servizi.',
                'Incaricati' => 'Care Provider associati alla sua utenza.'
       ] ]);

        
       DB::table('Trattamenti_Pazienti')->insert([
        		[ 'Id_Trattamento' => 2,
        				'Nome_T' => 'Gestione Sanitaria',
        				'Finalita_T' => 'Conservazione della storia medica',
        				'Modalita_T' => 'Accesso in lettura',
        				'Informativa' => 'Acconsentendo si dichiara la volonta di conservare la storia medica personale e di condividerla con gli operatori sanitari a lei associati.',
        				'Incaricati' => 'Care Provider'
        		] ]);
       
       DB::table('Trattamenti_Pazienti')->insert([
       		[ 'Id_Trattamento' => 3,
       				'Nome_T' => 'Raccolta di informazioni sanitarie',
       				'Finalita_T' => 'Finalità di governo di tali informazioni',
       				'Modalita_T' => 'Accesso in lettura e in scrittura',
       				'Informativa' => 'Acconsentendo permette al sistema di effettare la raccolta delle informazioni per la creazione di un registro complessivo di tutte le Patologie, Vaccini, Procedure Terapeutiche personali ',
       				'Incaricati' => 'Paziente'
       		] ]);
       
       
       DB::table('Trattamenti_Pazienti')->insert([
       		[ 'Id_Trattamento' => 4,
       				'Nome_T' => 'Messaggistica',
       				'Finalita_T' => 'Conservazione dei messaggi scambiati tra gli operatori sanitari e il paziente.',
       				'Modalita_T' => 'Accesso in lettura',
       				'Informativa' => 'Acconsentendo si dichiara la volonta di accedere al servizio di messaggistica. I messaggi scambiati saranno conservati per un periodo non superiore ad un anno dalla loro creazione.',
       				'Incaricati' => 'Care Provider, Paziente'
       		] ]);
       
       DB::table('Trattamenti_Pazienti')->insert([
       		[ 'Id_Trattamento' => 5,
       				'Nome_T' => 'Prenotazione',
       				'Finalita_T' => 'Accesso alle informazioni personali per usufruire del servizio di prenotazione.',
       				'Modalita_T' => 'Accesso in lettura',
       				'Informativa' => 'Acconsentendo si dichiara la volonta di rendere disponibili le proprie informazioni al servizio "prenotazioni".',
       				'Incaricati' => 'Care Provider, Paziente'
       		] ]);
       
       DB::table('Trattamenti_Pazienti')->insert([
       		[ 'Id_Trattamento' => 6,
       				'Nome_T' => 'Donazione organi',
       				'Finalita_T' => 'Conservazione della volonta di donare gli organi. La volontà sarà resa disponibile all ente regionali di competenza.',
       				'Modalita_T' => 'Accesso in lettura',
       				'Informativa' => 'Acconsentendo, la volonta di donare gl organi sarà consenservata nel nostro database e sarà comunicata all ente regionale di competenza.',
       				'Incaricati' => 'Care Provider, Paziente'
       		] ]);
       
       DB::table('Trattamenti_Pazienti')->insert([
       		[ 'Id_Trattamento' => 7,
       				'Nome_T' => 'Supporto Servizio 118',
       				'Finalita_T' => 'Accesso ai propri dati sanitari e personali da parte di un operatore di emergenza.',
       				'Modalita_T' => 'Accesso in lettura',
       				'Informativa' => 'Acconsentendo i propri dati personali e sanitari saranno accessibili agli operatori di emergenza.',
       				'Incaricati' => 'Utente Emergency'
       		] ]);
       
       DB::table('Trattamenti_Pazienti')->insert([
       		[ 'Id_Trattamento' => 8,
       				'Nome_T' => 'Indagini',
       				'Finalita_T' => 'Accesso alle Indagini che la riguardano da parte di un Operatore Sanitario.',
       				'Modalita_T' => 'Accesso in lettura',
       				'Informativa' => 'Acconsentendo le informazioni riguardanti le indagini saranno rese disponibili agli Operatori Sanitari a lei associati.',
       				'Incaricati' => 'Care Provider'
       		] ]);
       
       DB::table('Trattamenti_Pazienti')->insert([
       		[ 'Id_Trattamento' => 9,
       				'Nome_T' => 'Quality and Risk Managment ',
       				'Finalita_T' => 'Accesso ai propri dati di audit al fine di garantire un servizio sicuro ed efficiente.',
       				'Modalita_T' => 'Accesso in lettura',
       				'Informativa' => 'Acconsentendo le informazioni di Audit saranno utilizzati processi interni di monitoramento dei servizi.',
       				'Incaricati' => ' '
       		] ]);
       DB::table('Trattamenti_Pazienti')->insert([
       		[ 'Id_Trattamento' => 10,
       				'Nome_T' => 'Portabilità',
       				'Finalita_T' => 'Accesso al servizio di portabilità dei propri dati personali.',
       				'Modalita_T' => 'Accesso in lettura',
       				'Informativa' => 'Acconsentendo i propri dati personali e sanitari saranno utilizzati dal sistema per generare i file xml del servizio "Portabilità"',
       				'Incaricati' => 'Paziente'
       		] ]);
       
       DB::table('Trattamenti_Pazienti')->insert([
       		[ 'Id_Trattamento' => 11,
       				'Nome_T' => 'Conservazione dopo la cancellazione',
       				'Finalita_T' => 'Conservazione dei dati personali successivamente alla cancellazione dell account.',
       				'Modalita_T' => 'Accesso in lettura',
       				'Informativa' => 'Acconsentendo i propri dati personali e sanitari saranno conservati dal sistema per un periodo di tempo pari ad un anno oltre la data di cancellazione del proprio account',
       				'Incaricati' => 'Paziente'
       		] ]);
       
       DB::table('Trattamenti_Pazienti')->insert([
       		[ 'Id_Trattamento' => 12,
       				'Nome_T' => 'Scientifica',
       				'Finalita_T' => 'Utilizzo dei dati personali per indagini scientifiche.',
       				'Modalita_T' => 'Accesso in lettura',
       				'Informativa' => 'Acconsentendo i propri dati personali e sanitari saranno resi disponibili pr indagini scientifiche interne all azienda',
       				'Incaricati' => 'Paziente'
       		] ]);
       
       DB::table('Trattamenti_Pazienti')->insert([
       		[ 'Id_Trattamento' => 13,
       				'Nome_T' => 'Contatto di emergenza',
       				'Finalita_T' => 'Utilizzo del contatto di emerenza per infomrazione da utilizzare in situazioni di mergenza per la sua persona.',
       				'Modalita_T' => 'Accesso in lettura',
       				'Informativa' => 'Acconsentendo il suo contatto di emergenza sarà reso disponibile per comunicazioni urgenti.',
       				'Incaricati' => 'Paziente'
       		] ]);
       
    }
}
