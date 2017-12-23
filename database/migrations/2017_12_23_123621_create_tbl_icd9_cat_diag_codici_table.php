<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblIcd9CatDiagCodiciTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_icd9_cat_diag_codici', function(Blueprint $table)
		{
			$table->string('codice_categoria', 6)->primary();
			$table->string('codice_blocco', 4)->index('fk_tbl_icd9_cat_diag_codici_tbl_icd9_grup_diag_codici1_idx');
			$table->string('categoria_cod_descrizione', 120);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_icd9_cat_diag_codici');
	}

}
