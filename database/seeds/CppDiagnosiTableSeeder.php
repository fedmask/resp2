<?php

use Illuminate\Database\Seeder;

class CppDiagnosiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_cpp_diagnosi')->insert([
            [ 'id_diagnosi' => 1,
              'diagnosi_stato' => 'Esclusa',
              'careprovider' => 'Bob Kelso/(Esclusa)' ]
        ]);
        
        
        DB::table('tbl_cpp_diagnosi')->insert([
            [ 'id_diagnosi' => 2,
                'diagnosi_stato' => 'Esclusa',
                'careprovider' => 'Giacomo Kelso/(Confermata)-Marco Kelso/(Esclusa)' ]
        ]);
        
        
        DB::table('tbl_cpp_diagnosi')->insert([
            [ 'id_diagnosi' => 3,
                'diagnosi_stato' => 'Sospetta',
                'careprovider' => 'Marco Kelso/(Sospetta)' ]
        ]);
        
        
        DB::table('tbl_cpp_diagnosi')->insert([
            [ 'id_diagnosi' => 4,
                'diagnosi_stato' => 'Confermata',
                'careprovider' => 'Marco Kelso/(Confermata)' ]
        ]);
    }
}
