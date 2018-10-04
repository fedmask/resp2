<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblUtentiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_utenti', function(Blueprint $table)
		{
			$table->foreign('id_tipologia', 'fk_tbl_utenti_tipologia_idx')->references('id_tipologia')->on('tbl_utenti_tipologie')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_utenti', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_utenti_tipologia_idx');
		});
	}

}
