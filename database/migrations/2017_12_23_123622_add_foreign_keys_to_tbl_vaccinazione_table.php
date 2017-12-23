<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblVaccinazioneTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_vaccinazione', function(Blueprint $table)
		{
			$table->foreign('id_cpp', 'fk_tbl_vaccinazione_tbl_care_provider1')->references('id_cpp')->on('tbl_care_provider')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('vaccinazione_confidenzialita', 'fk_tbl_vaccinazione_tbl_livelli_confidenzialita1')->references('id_livello_confidenzialita')->on('tbl_livelli_confidenzialita')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_paziente', 'fk_tbl_vaccinazione_tbl_pazienti1')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_vaccino', 'fk_tbl_vaccinazione_tbl_vaccini1')->references('id_vaccino')->on('tbl_vaccini')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_vaccinazione', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_vaccinazione_tbl_care_provider1');
			$table->dropForeign('fk_tbl_vaccinazione_tbl_livelli_confidenzialita1');
			$table->dropForeign('fk_tbl_vaccinazione_tbl_pazienti1');
			$table->dropForeign('fk_tbl_vaccinazione_tbl_vaccini1');
		});
	}

}
