<?php

use Illuminate\Database\Seeder;

class PatientsMarriageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_stati_matrimoniali')->insert([
            'id_stato_matrimoniale' => 0,
            'stato_matrimoniale_nome' => 'Sposato',
            'stato_matrimoniale_descrizione' => '',
        ]);
        
        DB::table('tbl_stati_matrimoniali')->insert([
            'id_stato_matrimoniale' => 1,
            'stato_matrimoniale_nome' => 'Annullato',
            'stato_matrimoniale_descrizione' => '',
        ]);
        DB::table('tbl_stati_matrimoniali')->insert([
            'id_stato_matrimoniale' => 2,
            'stato_matrimoniale_nome' => 'Divorziato',
            'stato_matrimoniale_descrizione' => '',
        ]);
        DB::table('tbl_stati_matrimoniali')->insert([
            'id_stato_matrimoniale' => 3,
            'stato_matrimoniale_nome' => 'Interlocutorio',
            'stato_matrimoniale_descrizione' => '',
        ]);
        DB::table('tbl_stati_matrimoniali')->insert([
            'id_stato_matrimoniale' => 4,
            'stato_matrimoniale_nome' => 'Legalmente Separato',
            'stato_matrimoniale_descrizione' => '',
        ]);
        DB::table('tbl_stati_matrimoniali')->insert([
            'id_stato_matrimoniale' => 5,
            'stato_matrimoniale_nome' => 'Poligamo',
            'stato_matrimoniale_descrizione' => '',
        ]);
        DB::table('tbl_stati_matrimoniali')->insert([
            'id_stato_matrimoniale' => 6,
            'stato_matrimoniale_nome' => 'Mai sposato',
            'stato_matrimoniale_descrizione' => '',
        ]);
        DB::table('tbl_stati_matrimoniali')->insert([
            'id_stato_matrimoniale' => 7,
            'stato_matrimoniale_nome' => 'Convivente',
            'stato_matrimoniale_descrizione' => '',
        ]);
        DB::table('tbl_stati_matrimoniali')->insert([
            'id_stato_matrimoniale' => 8,
            'stato_matrimoniale_nome' => 'Vedovo',
            'stato_matrimoniale_descrizione' => '',
        ]);
    }
}
