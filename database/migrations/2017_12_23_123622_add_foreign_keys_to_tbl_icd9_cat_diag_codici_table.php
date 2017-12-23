<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblIcd9CatDiagCodiciTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_icd9_cat_diag_codici', function(Blueprint $table)
		{
			$table->foreign('codice_categoria', 'fk_tbl_icd9_cat_diag_codici_tbl_icd9_diag_codici')->references('codice_categoria')->on('tbl_icd9_diag_codici')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('codice_blocco', 'fk_tbl_icd9_cat_diag_codici_tbl_icd9_grup_diag_codici')->references('codice')->on('tbl_icd9_grup_diag_codici')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_icd9_cat_diag_codici', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_icd9_cat_diag_codici_tbl_icd9_diag_codici');
			$table->dropForeign('fk_tbl_icd9_cat_diag_codici_tbl_icd9_grup_diag_codici');
		});
	}

}
