<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(icd9CodesStrum::class);
        $this->call(TypesUsersTableSeeder::class);
        $this->call(StateSeeder::class);
		//Tabelle con dati statici
        $this->call(PatientsMarriageTableSeeder::class);
		$this->call(RolesTableSeeder::class);
		$this->call(DrugsCategoriesTableSeeder::class);
		$this->call(DrugsTableSeeder::class);
		$this->call(DrugsVSTableSeeder::class);
		$this->call(LevelConfTableSeeder::class);
		$this->call(LoincAnswerListTableSeeder::class);
		$this->call(LoincTableSeeder::class);
		$this->call(LoincSlabValuesTableSeeder::class);
		$this->call(ContactsTypesTableSeeder::class);
		//Fine tabelle dati statici
		$this->call(UsersTableSeeder::class);
		$this->call(CppUsers::class); //Va dopo l'inserimento dei comuni
		
		$this->call(PatientsTableSeeder::class);
        $this->call(TownTableSeeder::class);
        $this->call(CareProviderPeopleTableSeeder::class); //Va dopo l'inserimento dei comuni
        $this->call(ContactsTableSeeder::class);
        

        $this->call(VisiteTableSeeder::class);
        $this->call(ParametriVitaliTableSeeder::class);
        $this->call(CppPazienteTableSeeder::class);
        $this->call(DiagnosiTableSeeder::class);
        $this->call(CppDiagnosiTableSeeder::class);
        $this->call(CentriTipologieTableSeeder::class);
        $this->call(CentriIndaginiTableSeeder::class);
        $this->call(ModalitaContattiTableSeeder::class);
        $this->call(CentriContattiTableSeeder::class);
        $this->call(IndaginiTableSeeder::class);
        $this->call ( CareProviderPeopleTableSeeder::class );
        //$this->call ( MapsTableSeeder::class );
        $this->call ( ConfidenzialitaSeeder::class );
        
        $this->call ( ICD9_IDPT_OrganiSeeder::class );
        $this->call ( ICD9_IDPT_Sede_Tipo_InterventoSeeder::class );
        $this->call ( ICD9_IntrventiChirurgici_ProcTerapeuticheSeeder::class );
        $this->call ( ProcTerapSeeder::class );
        
        
        /*$this->call(Icd9EsamiTableSeeder::class);
        
       */

    }
}
