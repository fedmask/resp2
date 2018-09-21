<?php

use Illuminate\Database\Seeder;

class Observation extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_indagini')->insert([
            ['id_centro_indagine' => 1, 'id_cpp' => 1, 'id_diagnosi' => 1, "id_paziente" => 1, "indagine_codice_icd" => "00.01", "indagine_codice_loinc" => "1751-7", "indagine_data" => "2018-03-14", "indagine_aggiornamento" => "2018-03-14", "indagine_stato" => "programmata", "indagine_tipologia" => "Test prova", "indagine_motivo" => "provami", "indagine_referto" => "nulla", "indagine_allegato" => "nulla"]
        ]);
    }
}
