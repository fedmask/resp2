<?php
use Illuminate\Database\Seeder;

class ProcedureStatusSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_proc_status')->insert([
            
            'codice' => 'preparation',
            'descrizione' => 'The core event has not started yet, but some staging activities have begun (e.g. surgical suite preparation). Preparation stages may be tracked for billing purposes.'
        
        ]);
        
        DB::table('tbl_proc_status')->insert([
            
            'codice' => 'in-progres',
            'descrizione' =>'The event is currently occurring'
        
        ]);
        
        DB::table('tbl_proc_status')->insert([
            
            'codice' => 'suspended',
            'descrizione' =>'The event has been temporarily stopped but is expected to resume in the future'
        
        ]);
        
        DB::table('tbl_proc_status')->insert([
            
            'codice' => 'aborted',
            'descrizione' =>'The event was prior to the full completion of the intended actions'
        
        ]);
        
        DB::table('tbl_proc_status')->insert([
            
            'codice' => 'completated',
            'descrizione' =>'The event has now concluded'
        
        ]);
        DB::table('tbl_proc_status')->insert([
            
            'codice' => 'entred-in-error',
            'descrizione' =>'This electronic record should never have existed, though it is possible that real-world decisions were based on it. (If real-world activity has occurred, the status should be "cancelled" rather than "entered-in-error".)'
        
        ]);
        DB::table('tbl_proc_status')->insert([
            
            'codice' => 'unknown',
            'descrizione' =>'The authoring system does not know which of the status values currently applies for this request. Note: This concept is not to be used for "other" - one of the listed statuses is presumed to apply, it\'s just not known which one.'
        
        ]);
    }
}
