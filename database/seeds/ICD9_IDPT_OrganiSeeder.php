<?php

use Illuminate\Database\Seeder;

class ICD9_IDPT_OrganiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tbl_ICD9_IDPT_Organi')->insert([
            [   'id_IDPT_Organo' => '00',
                'descrizione' => 'Cuore'
            ]
        ]);
        
    }
}
