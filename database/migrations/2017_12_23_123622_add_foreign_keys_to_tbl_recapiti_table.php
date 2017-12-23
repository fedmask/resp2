<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblRecapitiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_recapiti', function(Blueprint $table)
		{
			$table->foreign('id_comune_residenza', 'fk_tbl_contatti_tbl_comuni1')->references('id_comune')->on('tbl_comuni')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_comune_nascita', 'fk_tbl_contatti_tbl_comuni2')->references('id_comune')->on('tbl_comuni')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_utente', 'fk_tbl_contatti_tbl_utenti1')->references('id_utente')->on('tbl_utenti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_recapiti', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_contatti_tbl_comuni1');
			$table->dropForeign('fk_tbl_contatti_tbl_comuni2');
			$table->dropForeign('fk_tbl_contatti_tbl_utenti1');
		});
	}

}
