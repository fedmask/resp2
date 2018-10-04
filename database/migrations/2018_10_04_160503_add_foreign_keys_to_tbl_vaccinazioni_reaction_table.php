<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblVaccinazioniReactionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_vaccinazioni_reaction', function(Blueprint $table)
		{
			$table->foreign('id_centro', 'fk_tbl_centri_indagini_tbl_reazioni')->references('id_centro')->on('tbl_centri_indagini')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_vaccinazione', 'fk_tbl_reazioni_tbl_vaccinazione')->references('id_vaccinazione')->on('tbl_vaccinazione')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_vaccinazioni_reaction', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_centri_indagini_tbl_reazioni');
			$table->dropForeign('fk_tbl_reazioni_tbl_vaccinazione');
		});
	}

}
