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
			$table->foreign('id_comune_residenza', 'tbl_recapiti_ibfk_1')->references('id_comune')->on('tbl_comuni')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_utente', 'tbl_recapiti_ibfk_2')->references('id_utente')->on('tbl_utenti')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
			$table->dropForeign('tbl_recapiti_ibfk_1');
			$table->dropForeign('tbl_recapiti_ibfk_2');
		});
	}

}
