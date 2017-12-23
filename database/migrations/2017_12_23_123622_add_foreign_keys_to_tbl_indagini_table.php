<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblIndaginiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_indagini', function(Blueprint $table)
		{
			$table->foreign('id_audit_log', 'fk_tbl_indagini_tbl_auditlog_log1')->references('id_audit')->on('tbl_auditlog_log')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_centro_indagine', 'fk_tbl_indagini_tbl_centri_indagini1')->references('id_centro')->on('tbl_centri_indagini')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_diagnosi', 'fk_tbl_indagini_tbl_diagnosi1')->references('id_diagnosi')->on('tbl_diagnosi')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('indagine_codice_icd', 'fk_tbl_indagini_tbl_icd9_esami_strumenti_codici1')->references('esame_codice')->on('tbl_icd9_esami_strumenti_codici')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('indagine_codice_loinc', 'fk_tbl_indagini_tbl_loinc1')->references('codice_loinc')->on('tbl_loinc')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_paziente', 'fk_tbl_indagini_tbl_pazienti1')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_indagini', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_indagini_tbl_auditlog_log1');
			$table->dropForeign('fk_tbl_indagini_tbl_centri_indagini1');
			$table->dropForeign('fk_tbl_indagini_tbl_diagnosi1');
			$table->dropForeign('fk_tbl_indagini_tbl_icd9_esami_strumenti_codici1');
			$table->dropForeign('fk_tbl_indagini_tbl_loinc1');
			$table->dropForeign('fk_tbl_indagini_tbl_pazienti1');
		});
	}

}
