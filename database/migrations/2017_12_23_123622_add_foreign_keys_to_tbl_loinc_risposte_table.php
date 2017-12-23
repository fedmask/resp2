<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblLoincRisposteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_loinc_risposte', function(Blueprint $table)
		{
			$table->foreign('codice_risposta', 'fk_tbl_loinc_risposte_tbl_loinc1')->references('codice_loinc')->on('tbl_loinc')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_loinc_risposte', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_loinc_risposte_tbl_loinc1');
		});
	}

}
