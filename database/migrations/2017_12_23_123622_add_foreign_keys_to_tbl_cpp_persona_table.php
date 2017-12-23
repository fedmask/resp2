<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblCppPersonaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_cpp_persona', function(Blueprint $table)
		{
			$table->foreign('id_comune', 'fk_tbl_cpp_persona_tbl_comuni')->references('id_comune')->on('tbl_comuni')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_utente', 'fk_tbl_cpp_persona_tbl_utenti')->references('id_utente')->on('tbl_utenti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_cpp_persona', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_cpp_persona_tbl_comuni');
			$table->dropForeign('fk_tbl_cpp_persona_tbl_utenti');
		});
	}

}
