<?php

use Illuminate\Database\Seeder;

class ContactsTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_tipologie_contatti')->insert([
            ['id_tipologia_contatto' => '0', 'tipologia_nome' => "Familiare"],
            ['id_tipologia_contatto' => '1', 'tipologia_nome' => "Tutore"],
            ['id_tipologia_contatto' => '2', 'tipologia_nome' => "Amico"],
            ['id_tipologia_contatto' => '3', 'tipologia_nome' => "Compagno"],
            ['id_tipologia_contatto' => '4', 'tipologia_nome' => "Lavorativo"],
            ['id_tipologia_contatto' => '5', 'tipologia_nome' => "Badante"],
            ['id_tipologia_contatto' => '6', 'tipologia_nome' => "Delegato"],
            ['id_tipologia_contatto' => '7', 'tipologia_nome' => "Garante"],
            ['id_tipologia_contatto' => '8', 'tipologia_nome' => "Padrone (nel caso di animale domestico)"],
            ['id_tipologia_contatto' => '9', 'tipologia_nome' => "Genitore"],
            ['id_tipologia_contatto' => '10', 'tipologia_nome' => "Emergenza"]
            ]);
    }
}
