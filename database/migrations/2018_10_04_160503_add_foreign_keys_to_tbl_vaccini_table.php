<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblVacciniTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_vaccini', function(Blueprint $table)
		{
			$table->foreign('id_vaccinazione', 'fk_tbl_vaccino_tbl_vaccinazione1_idx')->references('id_vaccinazione')->on('tbl_vaccinazione')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('Codice_ATC', 'tbl_vaccini_ibfk_1')->references('Codice_ATC')->on('ATC_Sottogruppo_Chimico')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_vaccini', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_vaccino_tbl_vaccinazione1_idx');
			$table->dropForeign('tbl_vaccini_ibfk_1');
		});
	}

}
