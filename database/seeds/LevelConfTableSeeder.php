<?php

use Illuminate\Database\Seeder;

class LevelConfTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_livelli_confidenzialita')->insert([
            ['id_livello_confidenzialita' => '1','confidenzialita_descrizione' => 'Nessuna Restrizione'],
            ['id_livello_confidenzialita' => '2','confidenzialita_descrizione' => 'Basso'],
            ['id_livello_confidenzialita' => '3','confidenzialita_descrizione' => 'Moderato'],
            ['id_livello_confidenzialita' => '4','confidenzialita_descrizione' => 'Normale'],
            ['id_livello_confidenzialita' => '5','confidenzialita_descrizione' => 'Riservato'],
            ['id_livello_confidenzialita' => '6','confidenzialita_descrizione' => 'Strettamente riservato']
        ]);
    }
}
