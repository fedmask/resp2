<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblDiagnosiEliminateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_diagnosi_eliminate', function(Blueprint $table)
		{
			$table->foreign('id_diagnosi', 'fk_tbl_diagnosi_eliminate_tbl_diagnosi1_idx')->references('id_diagnosi')->on('tbl_diagnosi')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_utente', 'fk_tbl_diagnosi_eliminate_tbl_pazienti1_idx')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_diagnosi_eliminate', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_diagnosi_eliminate_tbl_diagnosi1_idx');
			$table->dropForeign('fk_tbl_diagnosi_eliminate_tbl_pazienti1_idx');
		});
	}

}
