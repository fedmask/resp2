<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblPazientiVisiteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_pazienti_visite', function(Blueprint $table)
		{
			$table->foreign('id_cpp', 'fk_tbl_pazienti_visite_tbl_medici1')->references('id_cpp')->on('tbl_care_provider')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_paziente', 'fk_tbl_pazienti_visite_tbl_pazienti1')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_pazienti_visite', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_pazienti_visite_tbl_medici1');
			$table->dropForeign('fk_tbl_pazienti_visite_tbl_pazienti1');
		});
	}

}
