<?php

use Illuminate\Database\Seeder;

class ProcedureOutcomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_proc_outcome')->insert([
            
            'codice' => '385669000',
            'descrizione'=>'Successful '
            
        ]);
        
        DB::table('tbl_proc_outcome')->insert([
            
            'codice' => '385671000',
            'descrizione'=>'Unsuccessful'
            
        ]);
        
        DB::table('tbl_proc_outcome')->insert([
            
            'codice' => '385670004',
            'descrizione'=>'Partially successful'
            
        ]);
    }
}
