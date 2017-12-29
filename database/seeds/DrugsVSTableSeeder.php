<?php

use Illuminate\Database\Seeder;

class DrugsVSTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 DB::table('tbl_farmaci_tipologie_somm')->insert([
      ['id_farmaco_somministrazione' => 'ep','somministrazione_descrizione' => 'epidurale 
'],
      ['id_farmaco_somministrazione' => 'ev ','somministrazione_descrizione' => 'endovenosa 
'],
      ['id_farmaco_somministrazione' => 'id ','somministrazione_descrizione' => 'intradermica 
'],
      ['id_farmaco_somministrazione' => 'im ','somministrazione_descrizione' => 'intramuscolare 
'],
      ['id_farmaco_somministrazione' => 'inal ','somministrazione_descrizione' => 'inalatoria 
'],
      ['id_farmaco_somministrazione' => 'incam','somministrazione_descrizione' => 'intracamerale 
'],
      ['id_farmaco_somministrazione' => 'incav','somministrazione_descrizione' => 'intracavernosa 
'],
      ['id_farmaco_somministrazione' => 'inles','somministrazione_descrizione' => 'intrealesione 
'],
      ['id_farmaco_somministrazione' => 'intec','somministrazione_descrizione' => 'intratecale 
'],
      ['id_farmaco_somministrazione' => 'invas','somministrazione_descrizione' => 'intravasale 
'],
      ['id_farmaco_somministrazione' => 'invit','somministrazione_descrizione' => 'intravitreale 
'],
      ['id_farmaco_somministrazione' => 'loc ','somministrazione_descrizione' => 'locale 
'],
      ['id_farmaco_somministrazione' => 'nas ','somministrazione_descrizione' => 'nasale (sistemica) 
'],
      ['id_farmaco_somministrazione' => 'os ','somministrazione_descrizione' => 'orale 
'],
      ['id_farmaco_somministrazione' => 'rett ','somministrazione_descrizione' => 'rettale 
'],
      ['id_farmaco_somministrazione' => 'sc ','somministrazione_descrizione' => 'sottocutanea 
'],
      ['id_farmaco_somministrazione' => 'sl ','somministrazione_descrizione' => 'sublinguale 
'],
      ['id_farmaco_somministrazione' => 'td ','somministrazione_descrizione' => 'transdermica 
'],
      ['id_farmaco_somministrazione' => 'trach','somministrazione_descrizione' => 'endotracheale 
'],
      ['id_farmaco_somministrazione' => 'vesc ','somministrazione_descrizione' => 'intravescicale 
'],
    ]);
    }
}
