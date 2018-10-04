<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblLoincRisposteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_loinc_risposte', function(Blueprint $table)
		{
			$table->string('id_codice', 10)->nullable()->index('fk_tbl_loinc_risposte1_idx');
			$table->string('codice_risposta', 100)->nullable()->index('fk_tbl_loinc_risposte2_idx');
			$table->string('codice_loinc', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_loinc_risposte');
	}

}
