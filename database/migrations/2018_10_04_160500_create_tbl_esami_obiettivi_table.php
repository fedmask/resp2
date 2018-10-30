<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblEsamiObiettiviTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_esami_obiettivi', function(Blueprint $table)
		{
			$table->increments('id_esame_obiettivo');
			$table->integer('id_paziente')->unsigned()->index('fk_tbl_esami_obiettivi_tbl_pazienti1_idx');
			$table->string('codice_risposta_loinc', 10)->nullable()->index('fk_tbl_esami_obiettivi_tbl_loinc_risposte1_idx');
			$table->integer('id_diagnosi');
			$table->date('esame_data');
			$table->date('esame_aggiornamento');
			$table->longText('esame_stato')->nullable();
			$table->longText('esame_risultato', 15)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_esami_obiettivi');
	}

}
