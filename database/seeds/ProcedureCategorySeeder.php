<?php

use Illuminate\Database\Seeder;

class ProcedureCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_proc_cat')->insert([
            'codice' => '24642003',
            'descrizione' => 'Psychiatry procedure or service'
           
        ]);
        DB::table('tbl_proc_cat')->insert([
            'codice' => '409063005',
            'descrizione' => ' Counselling '
            
        ]);
        DB::table('tbl_proc_cat')->insert([
            'codice' => '409073007',
            'descrizione' => ' Education'
            
        ]);
        DB::table('tbl_proc_cat')->insert([
            'codice' => '387713003',
            'descrizione' => 'Surgical procedure'
            
        ]);
        
        DB::table('tbl_proc_cat')->insert([
            'codice' => '103693007',
            'descrizione' => 'Diagnostic procedure '
            
        ]);
        DB::table('tbl_proc_cat')->insert([
            'codice' => '46947000',
            'descrizione' => 'Chiropractic manipulation'
            
        ]);
        
        
    }
}
