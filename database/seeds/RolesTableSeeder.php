<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    DB::table('tbl_utenti_tipologie')->insert([
      ['id_tipologia' => '118','tipologia_nome' => '118','tipologia_descrizione' => 'Medico 118'],
      ['id_tipologia' => 'amm','tipologia_nome' => 'amm','tipologia_descrizione' => 'Amministratore'],
      ['id_tipologia' => 'ass','tipologia_nome' => 'ass','tipologia_descrizione' => 'Assistito'],
      ['id_tipologia' => 'aud','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Audiometrista'],
      ['id_tipologia' => 'emg','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Operatore Emergenza'],
      ['id_tipologia' => 'far','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Farmacista'],
      ['id_tipologia' => 'fst','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Fisioterapista'],
      ['id_tipologia' => 'igd','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Igienista dentale'],
      ['id_tipologia' => 'inf','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Infermiere'],
      ['id_tipologia' => 'lgp','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Logopedista'],
      ['id_tipologia' => 'mcs','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Medico Continuita\' Assistenziale'],
      ['id_tipologia' => 'mmg','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Medico di medicina generale'],
      ['id_tipologia' => 'mos','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Medico Ospedaliero'],
      ['id_tipologia' => 'mps','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Medico di Pronto Soccorso'],
      ['id_tipologia' => 'msa','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Medico Specialista Ambulatoriale'],
      ['id_tipologia' => 'mso','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Medico Specialista Ospedaliero'],
      ['id_tipologia' => 'odt','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Odontoiatra'],
      ['id_tipologia' => 'otc','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Ottico'],
      ['id_tipologia' => 'oth','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Altro'],
      ['id_tipologia' => 'pls','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Pediatra di libera scelta'],
      ['id_tipologia' => 'psi','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Psicologo'],
      ['id_tipologia' => 'tps','tipologia_nome' => 'cpp','tipologia_descrizione' => 'Tecnico Psicologo'],
      ['id_tipologia' => 'tut','tipologia_nome' => 'tut','tipologia_descrizione' => 'Tutor']
    ]);
    }
}
