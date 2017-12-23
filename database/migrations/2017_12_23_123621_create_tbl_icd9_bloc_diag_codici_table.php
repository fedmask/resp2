<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblIcd9BlocDiagCodiciTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_icd9_bloc_diag_codici', function(Blueprint $table)
		{
			$table->string('codice_blocco', 4)->primary();
			$table->string('codice_gruppo', 4)->index('fk_tbl_icd9_bloc_diag_codici_tbl_icd9_grup_diag_codici1_idx');
			$table->text('blocco_cod_descrizione', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_icd9_bloc_diag_codici');
	}

}
