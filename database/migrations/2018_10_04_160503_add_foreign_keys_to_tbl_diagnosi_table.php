<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblDiagnosiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_diagnosi', function(Blueprint $table)
		{
			$table->foreign('diagnosi_confidenzialita', 'tbl_diagnosi_ibfk_1')->references('id_livello_confidenzialita')->on('tbl_livelli_confidenzialita')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_paziente', 'tbl_diagnosi_ibfk_2')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('diagnosi_stato', 'tbl_diagnosi_ibfk_3')->references('Code')->on('ConditionClinicalStatus')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('verificationStatus', 'tbl_diagnosi_ibfk_4')->references('Code')->on('ConditionVerificationStatus')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('severity', 'tbl_diagnosi_ibfk_5')->references('Code')->on('ConditionSeverity')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('code', 'tbl_diagnosi_ibfk_6')->references('Code')->on('ConditionCode')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('bodySite', 'tbl_diagnosi_ibfk_7')->references('Code')->on('ConditionBodySite')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('stageSummary', 'tbl_diagnosi_ibfk_8')->references('Code')->on('ConditionStageSummary')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('evidenceCode', 'tbl_diagnosi_ibfk_9')->references('Code')->on('ConditionEvidenceCode')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_diagnosi', function(Blueprint $table)
		{
			$table->dropForeign('tbl_diagnosi_ibfk_1');
			$table->dropForeign('tbl_diagnosi_ibfk_2');
			$table->dropForeign('tbl_diagnosi_ibfk_3');
			$table->dropForeign('tbl_diagnosi_ibfk_4');
			$table->dropForeign('tbl_diagnosi_ibfk_5');
			$table->dropForeign('tbl_diagnosi_ibfk_6');
			$table->dropForeign('tbl_diagnosi_ibfk_7');
			$table->dropForeign('tbl_diagnosi_ibfk_8');
			$table->dropForeign('tbl_diagnosi_ibfk_9');
		});
	}

}
