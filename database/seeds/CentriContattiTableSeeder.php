<?php

use Illuminate\Database\Seeder;

class CentriContattiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_centri_contatti')->insert([
            [   'id_contatto' => 1,
                'id_centro' => 1,
                'id_modalita_contatto' => 1,
                'contatto_valore' => '333 292923' 
            ]
        ]);
        
        DB::table('tbl_centri_contatti')->insert([
            [   'id_contatto' => 2,
                'id_centro' => 2,
                'id_modalita_contatto' => 1,
                'contatto_valore' => '080 592723'
            ]
        ]);
        
        
        DB::table('tbl_centri_contatti')->insert([
            [   'id_contatto' => 3,
                'id_centro' => 3,
                'id_modalita_contatto' => 1,
                'contatto_valore' => '393 297923'
            ]
        ]);
        
        DB::table('tbl_centri_contatti')->insert([
            [   'id_contatto' => 4,
                'id_centro' => 1,
                'id_modalita_contatto' => 1,
                'contatto_valore' => '080 982223'
            ]
        ]);
    }
}
