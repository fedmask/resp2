<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblIcd9DiagCodiciTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_icd9_diag_codici', function(Blueprint $table)
		{
			$table->increments('codice_diag');
			$table->string('codice_categoria', 6)->nullable()->index('codie_categoria');
			$table->string('codice_descrizione', 120)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_icd9_diag_codici');
	}

}
