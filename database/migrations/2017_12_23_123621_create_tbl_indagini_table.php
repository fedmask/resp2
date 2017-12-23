<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblIndaginiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_indagini', function(Blueprint $table)
		{
			$table->integer('id_indagine')->primary();
			$table->integer('id_centro_indagine')->index('fk_tbl_indagini_tbl_centri_indagini1_idx');
			$table->integer('id_diagnosi')->index('fk_tbl_indagini_tbl_diagnosi1_idx');
			$table->integer('id_paziente')->unsigned()->index('fk_tbl_indagini_tbl_pazienti1_idx');
			$table->integer('id_audit_log')->index('fk_tbl_indagini_tbl_auditlog_log1_idx');
			$table->string('indagine_codice_icd', 7)->index('fk_tbl_indagini_tbl_icd9_esami_strumenti_codici1_idx');
			$table->string('indagine_codice_loinc', 10)->index('fk_tbl_indagini_tbl_loinc1_idx');
			$table->date('indagine_data');
			$table->date('indagine_aggiornamento');
			$table->string('indagine_stato', 12);
			$table->text('indagine_tipologia', 65535);
			$table->text('indagine_motivo', 65535);
			$table->text('indagine_referto', 65535);
			$table->text('indagine_allegato', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_indagini');
	}

}
