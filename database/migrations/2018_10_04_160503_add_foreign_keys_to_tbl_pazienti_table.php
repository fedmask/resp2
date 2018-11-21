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
			$table->foreign('id_utente', 'FOREIGN_UTENTE_idx')->references('id_utente')->on('tbl_utenti')->onUpdate('NO ACTION')->onDelete('cascade');
			$table->foreign('id_stato_matrimoniale', 'tbl_pazienti_ibfk_1')->references('Code')->on('MaritalStatus')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('paziente_sesso', 'tbl_pazienti_ibfk_2')->references('Code')->on('Gender')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('paziente_lingua', 'tbl_pazienti_ibfk_3')->references('Code')->on('Languages')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
			$table->dropForeign('FOREIGN_UTENTE_idx');
			$table->dropForeign('tbl_pazienti_ibfk_1');
			$table->dropForeign('tbl_pazienti_ibfk_2');
			$table->dropForeign('tbl_pazienti_ibfk_3');
		});
	}

}
