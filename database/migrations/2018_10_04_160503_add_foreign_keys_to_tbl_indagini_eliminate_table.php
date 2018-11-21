<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblIndaginiEliminateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_indagini_eliminate', function(Blueprint $table)
		{
			$table->foreign('id_indagine', 'fk_tbl_indagini_eliminate_tbl_indagini1_idx')->references('id_indagine')->on('tbl_indagini')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_utente', 'fk_tbl_indagini_eliminate_tbl_utenti1_idx')->references('id_utente')->on('tbl_utenti')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_indagini_eliminate', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_indagini_eliminate_tbl_indagini1_idx');
			$table->dropForeign('fk_tbl_indagini_eliminate_tbl_utenti1_idx');
		});
	}

}
