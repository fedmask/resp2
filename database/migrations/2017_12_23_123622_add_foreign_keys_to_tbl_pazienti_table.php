<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblPazientiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_pazienti', function(Blueprint $table)
		{
			$table->foreign('id_utente', 'FOREIGN_UTENTE')->references('id_utente')->on('tbl_utenti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		//	$table->foreign('id_stato_matrimoniale', 'fk_tbl_pazienti_tbl_stati_matrimoniali1')->references('id_stato_matrimoniale')->on('tbl_stati_matrimoniali')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_pazienti', function(Blueprint $table)
		{
			$table->dropForeign('FOREIGN_UTENTE');
			$table->dropForeign('fk_tbl_pazienti_tbl_stati_matrimoniali1');
		});
	}

}
