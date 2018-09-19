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
      /*  $this->call(TypesUsersTableSeeder::class);
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
        */
        $this->call(StatiMatrimonialiTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(ContactRelationshipTableSeeder::class);
        $this->call(QualificationCodeTableSeeder::class);
        $this->call(OrganizationTypeTableSeeder::class);
        $this->call(ConditionClinicalStatusTableSeeder::class);
        $this->call(ConditionSeverityTableSeeder::class);
        $this->call(MedicationStatusTableSeeder::class);
        $this->call(EncounterParticipantTypeTableSeeder::class);
        $this->call(ProcedureFollowUpTableSeeder::class);
        $this->call(ImmunizationStatusTableSeeder::class);
        $this->call(ImmunizationRouteTableSeeder::class);
        $this->call(TipoContattoTableSeeder::class);
        $this->call(DeviceStatusTableSeeder::class);
        $this->call(AllergyIntolleranceClinicalStatusTableSeeder::class);
        
        //TODO AllergyIntolleranceVerificationStatus
        
        
       /* $this->call(PatientsTableSeeder::class);
        
        $this->call(TownTableSeeder::class);
        
        $this->call(PatientContactTableSeeder::class);
        
        $this->call(PazienteCommunicationTableSeeder::class);
        
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
        /*$this->call(Icd9EsamiTableSeeder::class);
        
        */

    }
}
