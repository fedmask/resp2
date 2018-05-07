<?php

use Illuminate\Database\Seeder;

class CentriIndaginiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_centri_indagini')->insert([
            [   'id_centro' => 1,
                'id_tipologia' => 1,
                'id_comune' => 1,
                'id_ccp_persona' => 1,
                'centro_nome' => 'Nome Centro 1',
                'centro_indirizzo' => 'Indirizzo Centro 1',
                'centro_mail' => 'mi46@hotmail.it',
                'centro_resp' => 1]
        ]);
        
        
        DB::table('tbl_centri_indagini')->insert([
            [   'id_centro' => 2,
                'id_tipologia' => 1,
                'id_comune' => 2,
                'id_ccp_persona' => 1,
                'centro_nome' => 'Nome Centro 2',
                'centro_indirizzo' => 'Indirizzo Centro 2',
                'centro_mail' => 'v.pennella1@studenti.uniba.it',
                'centro_resp' => 1]
            ]);
        
        
        DB::table('tbl_centri_indagini')->insert([
            [   'id_centro' => 3,
                'id_tipologia' => 3,
                'id_comune' => 3,
                'id_ccp_persona' => 1,
                'centro_nome' => 'Nome Centro 3',
                'centro_indirizzo' => 'Indirizzo Centro 3',
                'centro_mail' => 'Centro mail 3',
                'centro_resp' => 0]
            ]);
        
    }
}
