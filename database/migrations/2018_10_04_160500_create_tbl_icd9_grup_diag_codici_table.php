<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblIcd9GrupDiagCodiciTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_icd9_grup_diag_codici', function(Blueprint $table)
		{
			$table->string('codice', 4)->nullable()->index('fk_tbl_icd9_grup_diag_codici_idx');
			$table->string('gruppo_descrizione', 120)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_icd9_grup_diag_codici');
	}

}
