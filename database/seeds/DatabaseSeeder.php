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

        $this->call(StatiMatrimonialiTableSeeder::class);
        
        //Tabelle con dati statici (Codifiche FHIR)
        $this->call(MaritalStatusTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(ContactRelationshipTableSeeder::class);
        $this->call(QualificationCodeTableSeeder::class);
        $this->call(OrganizationTypeTableSeeder::class);
        $this->call(ConditionVerificationStatusTableSeeder::class);
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
        $this->call(AllergyIntolleranceCVerificationStatusTableSeeder::class);
        $this->call(AllergyIntolleranceTypeTableSeeder::class);
        $this->call(AllergyIntolleranceCategoryTableSeeder::class);
        $this->call(AllergyIntolleranceCriticalityTableSeeder::class);
        $this->call(AllergyIntolleranceReactionSeverityTableSeeder::class);
        $this->call(ConditionCodeTableSeeder::class);
        $this->call(FamilyMemberHistoryConditionOutcomeTableSeeder::class);
        $this->call(ConditionBodySiteTableSeeder::class);
        $this->call(ConditionStageSummaryTableSeeder::class);
        $this->call(ConditionEvidenceCodeTableSeeder::class);
        $this->call(AllergyIntolleranceCodeTableSeeder::class);
        $this->call(AllergyIntolleranceReactionExposureRouteTableSeeder::class);
        $this->call(AllergyIntolleranceReactionManifestationTableSeeder::class);
        $this->call(AllergyIntolleranceReactionSubstanceTableSeeder::class);
        $this->call(DeviceTypeTableSeeder::class);
        $this->call(EncounterReasonTableSeeder::class);
        $this->call(ImmunizationVaccineCodeTableSeeder::class);
        $this->call(MedicationCodeTableSeeder::class);
        $this->call(MedicationFormTableSeeder::class);
        $this->call(ProcedureBodySiteTableSeeder::class);
        $this->call(ProcedureCodeTableSeeder::class);
        $this->call(ProcedureComplicationTableSeeder::class);
        $this->call(ProcedureNotDoneReasonTableSeeder::class);
        $this->call(ProcedureReasonCodeTableSeeder::class);
        //Fine Codifiche FHIR
        //Fine tabelle dati statici
        
        
        $this->call(UsersTableSeeder::class);
        $this->call(CppUsers::class); 
        $this->call(PatientsTableSeeder::class);

        $this->call(PatientContactTableSeeder::class);

        $this->call(TownTableSeeder::class);
        $this->call(CareProviderPeopleTableSeeder::class); 
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
        $this->call ( ConfidenzialitaSeeder::class );
        $this->call ( ICD9_IDPT_OrganiSeeder::class );
        $this->call ( ICD9_IDPT_Sede_Tipo_InterventoSeeder::class );
        $this->call ( ICD9_IntrventiChirurgici_ProcTerapeuticheSeeder::class );
        $this->call ( SpecializationSeeder::class );
        $this->call ( Visita_SpecializationSeeder::class );
        $this->call ( VisiteTableSeeder::class );
        $this->call ( RolesTableSeeder::class );
        $this->call ( ProcedureCategorySeeder::class );
        $this->call ( ProcedureOutcomeSeeder::class );
        $this->call ( ProcedureStatusSeeder::class );
        $this->call ( ProcTerapSeeder::class );

        $this->call ( CppQualificationTableSeeder::class );

        
        
        
        
        $this->call ( Cpp_SpecializationSeeder::class );
        
        
        
        $this->call ( ATCGruppoAnatomicoPSeeder::class );
        $this->call (ATCGruppoTerapeuticoPSeeder::class );
        $this->call ( ATCSottogruppoTerapeuticoFSeeder::class );
        $this->call ( ATCSottogruppoChimicoTFSeeder::class );
        $this->call ( ATCSottogruppoChimicoSeeder::class );
        
       
    }
}
