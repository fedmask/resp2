<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblCareProviderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_care_provider', function(Blueprint $table)
		{
			$table->foreign('id_utente', 'fk_tbl_cpp_tbl_utenti')->references('id_utente')->on('tbl_utenti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_cpp_tipologia', 'fk_tbl_medici_tbl_ruoli_tipologie')->references('id_tipologia')->on('tbl_cpp_tipologie')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_care_provider', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_cpp_tbl_utenti');
			$table->dropForeign('fk_tbl_medici_tbl_ruoli_tipologie');
		});
	}

}
