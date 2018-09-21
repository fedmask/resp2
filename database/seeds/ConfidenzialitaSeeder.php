<?php

use Illuminate\Database\Seeder;

class ConfidenzialitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        DB::table('tbl_livelli_confidenzialita')->insert([
            'id_livello_confidenzialita' => '1',
            'confidenzialita_descrizione' => 'Descrizione'
            
        ]);
        
        DB::table('tbl_livelli_confidenzialita')->insert([
            'id_livello_confidenzialita' => '2',
            'confidenzialita_descrizione' => 'Descrizione'
            
        ]);
        
        DB::table('tbl_livelli_confidenzialita')->insert([
            'id_livello_confidenzialita' => '3',
            'confidenzialita_descrizione' => 'Descrizione'
            
        ]);
        
    }
}
