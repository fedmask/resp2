<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblContattiPazientiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_contatti_pazienti', function(Blueprint $table)
		{
			$table->foreign('id_paziente', 'fk_tbl_contatti_pazienti_tbl_pazienti')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_contatto_tipologia', 'fk_tbl_contatti_pazienti_tbl_tipologie_contatti')->references('id_tipologia_centro_contatto')->on('tbl_tipologie_contatti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_contatti_pazienti', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_contatti_pazienti_tbl_pazienti');
			$table->dropForeign('fk_tbl_contatti_pazienti_tbl_tipologie_contatti');
		});
	}

}
