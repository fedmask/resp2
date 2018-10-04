<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblEsamiObiettiviTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_esami_obiettivi', function(Blueprint $table)
		{
			$table->foreign('codice_risposta_loinc', 'fk_tbl_esami_obiettivi_tbl_loinc_risposte1_idx')->references('codice_risposta')->on('tbl_loinc_risposte')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_paziente', 'fk_tbl_esami_obiettivi_tbl_pazienti1_idx')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_esami_obiettivi', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_esami_obiettivi_tbl_loinc_risposte1_idx');
			$table->dropForeign('fk_tbl_esami_obiettivi_tbl_pazienti1_idx');
		});
	}

}
