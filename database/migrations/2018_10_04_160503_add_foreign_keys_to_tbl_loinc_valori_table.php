<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblLoincValoriTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_loinc_valori', function(Blueprint $table)
		{
			$table->foreign('id_codice', 'fk_tbl_loinc_valori_tbl_loinc1_idx')->references('codice_loinc')->on('tbl_loinc')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_loinc_valori', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_loinc_valori_tbl_loinc1_idx');
		});
	}

}
