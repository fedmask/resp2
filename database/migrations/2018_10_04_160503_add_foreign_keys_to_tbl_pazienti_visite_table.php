<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblPazientiVisiteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_pazienti_visite', function(Blueprint $table)
		{
			$table->foreign('id_cpp', 'tbl_pazienti_visite_ibfk_1')->references('id_cpp')->on('tbl_care_provider')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('id_paziente', 'tbl_pazienti_visite_ibfk_2')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('status', 'tbl_pazienti_visite_ibfk_3')->references('Code')->on('EncounterStatus')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('class', 'tbl_pazienti_visite_ibfk_4')->references('Code')->on('EncounterClass')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('reason', 'tbl_pazienti_visite_ibfk_5')->references('Code')->on('EncounterReason')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_pazienti_visite', function(Blueprint $table)
		{
			$table->dropForeign('tbl_pazienti_visite_ibfk_1');
			$table->dropForeign('tbl_pazienti_visite_ibfk_2');
		});
	}

}
