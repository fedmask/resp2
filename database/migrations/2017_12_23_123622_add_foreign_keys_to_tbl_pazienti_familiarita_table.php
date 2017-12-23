<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblPazientiFamiliaritaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_pazienti_familiarita', function(Blueprint $table)
		{
			$table->foreign('id_paziente', 'fk_tbl_pazienti_familiarita_tbl_pazienti1')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_parente', 'fk_tbl_pazienti_familiarita_tbl_utenti1')->references('id_utente')->on('tbl_utenti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_pazienti_familiarita', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_pazienti_familiarita_tbl_pazienti1');
			$table->dropForeign('fk_tbl_pazienti_familiarita_tbl_utenti1');
		});
	}

}
