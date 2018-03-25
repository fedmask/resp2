<?php

use Illuminate\Database\Seeder;

class Diagnosis extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_diagnosi')->insert([
            ['id_diagnosi' => 1, 'id_paziente' => 1, 'diagnosi_confidenzialita' => 2, "diagnosi_inserimento_data" => "2018-03-02", "diagnosi_aggiornamento_data" => "2018-03-02", "diagnosi_patologia" => "Test di prova", "diagnosi_stato" => 3, "diagnosi_guarigione_data" => "2018-12-14"]
        ]);
    }
}
