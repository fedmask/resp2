<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblProcTerapeuticheTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_proc_terapeutiche', function(Blueprint $table)
		{
			$table->foreign('CareProvider', 'fk_tb_cpp_tb_procedure_treapeutiche')->references('id_cpp')->on('tbl_care_provider')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('Codice_icd9', 'fk_tb_icd9_tb_procedure_treapeutiche')->references('Codice_ICD9')->on('Tbl_ICD9_ICPT')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('Category', 'fk_tb_proc_category')->references('codice')->on('tbl_proc_cat')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('outCome', 'fk_tb_proc_outcome')->references('codice')->on('tbl_proc_outcome')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('Status', 'fk_tb_proc_status')->references('codice')->on('tbl_proc_status')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('Diagnosi', 'tbl_proc_terapeutiche_ibfk_1')->references('id_diagnosi')->on('tbl_diagnosi')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('Paziente', 'tbl_proc_terapeutiche_ibfk_2')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('code', 'tbl_proc_terapeutiche_ibfk_3')->references('Code')->on('ProcedureCode')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('reasonCode', 'tbl_proc_terapeutiche_ibfk_4')->references('Code')->on('ProcedureReasonCode')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('bodySite', 'tbl_proc_terapeutiche_ibfk_5')->references('Code')->on('ProcedureBodySite')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('followUp', 'tbl_proc_terapeutiche_ibfk_6')->references('Code')->on('ProcedureFollowUp')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('notDoneReason', 'tbl_proc_terapeutiche_ibfk_7')->references('Code')->on('ProcedureNotDoneReason')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('complication', 'tbl_proc_terapeutiche_ibfk_8')->references('Code')->on('ProcedureComplication')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_proc_terapeutiche', function(Blueprint $table)
		{
			$table->dropForeign('fk_tb_cpp_tb_procedure_treapeutiche');
			$table->dropForeign('fk_tb_icd9_tb_procedure_treapeutiche');
			$table->dropForeign('fk_tb_proc_category');
			$table->dropForeign('fk_tb_proc_outcome');
			$table->dropForeign('fk_tb_proc_status');
			$table->dropForeign('tbl_proc_terapeutiche_ibfk_1');
			$table->dropForeign('tbl_proc_terapeutiche_ibfk_2');
			$table->dropForeign('tbl_proc_terapeutiche_ibfk_3');
			$table->dropForeign('tbl_proc_terapeutiche_ibfk_4');
			$table->dropForeign('tbl_proc_terapeutiche_ibfk_5');
			$table->dropForeign('tbl_proc_terapeutiche_ibfk_6');
			$table->dropForeign('tbl_proc_terapeutiche_ibfk_7');
			$table->dropForeign('tbl_proc_terapeutiche_ibfk_8');
		});
	}

}
