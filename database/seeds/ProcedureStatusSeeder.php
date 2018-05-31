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
            
            'codice' => 'preparation'
            
        ]);
        
        DB::table('tbl_proc_status')->insert([
            
            'codice' => 'in-progres'
            
        ]);
        
        DB::table('tbl_proc_status')->insert([
            
            'codice' => 'suspended'
            
        ]);
        
        DB::table('tbl_proc_status')->insert([
            
            'codice' => 'aborted'
            
        ]);
        
        DB::table('tbl_proc_status')->insert([
            
            'codice' => 'completated'
            
        ]);
        DB::table('tbl_proc_status')->insert([
            
            'codice' => 'entred-in-error'
            
        ]);
        DB::table('tbl_proc_status')->insert([
            
            'codice' => 'unknown'
            
        ]);
    }
}
