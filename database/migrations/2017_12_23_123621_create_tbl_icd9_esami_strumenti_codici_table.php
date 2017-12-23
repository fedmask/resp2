<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblIcd9EsamiStrumentiCodiciTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_icd9_esami_strumenti_codici', function(Blueprint $table)
		{
			$table->string('esame_codice', 7)->primary();
			$table->string('esame_descrizione', 120);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_icd9_esami_strumenti_codici');
	}

}
