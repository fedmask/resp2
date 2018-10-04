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
			$table->increments('codice_blocco');
			$table->string('codice_gruppo', 4)->nullable()->index('fk_tbl_icd9_bloc_diag_codici_tbl_icd9_grup_diag_codici1_idx');
			$table->text('blocco_cod_descrizione', 65535)->nullable();
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
