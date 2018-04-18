<?php

use Illuminate\Database\Seeder;

class Icd9EsamiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_icd9_esami_strumenti_codici')->insert([
            [   'esame_codice' => '0000001',
                'esame_descrizione' => 'Descrizione esame 1'
            ]
        ]);
        
        DB::table('tbl_icd9_esami_strumenti_codici')->insert([
            [   'esame_codice' => '0000002',
                'esame_descrizione' => 'Descrizione esame 2'
            ]
        ]);
        
        
        DB::table('tbl_icd9_esami_strumenti_codici')->insert([
            [   'esame_codice' => '0000003',
                'esame_descrizione' => 'Descrizione esame 3'
            ]
        ]);
    }
}
