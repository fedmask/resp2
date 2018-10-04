<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblFamilyCondictionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_FamilyCondiction', function(Blueprint $table)
		{
			$table->foreign('Codice_ICD9', 'FOREIGN_Diagn_Condition')->references('Codice_ICD9')->on('Tbl_ICD9_ICPT')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_parente', 'FOREIGN_Parente_Condition')->references('id_parente')->on('tbl_Parente')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('code_fhir', 'tbl_FamilyCondiction_ibfk_1')->references('Code')->on('ConditionCode')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('outCome', 'tbl_FamilyCondiction_ibfk_2')->references('Code')->on('FamilyMemberHistoryConditionOutcome')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_FamilyCondiction', function(Blueprint $table)
		{
			$table->dropForeign('FOREIGN_Diagn_Condition');
			$table->dropForeign('FOREIGN_Parente_Condition');
			$table->dropForeign('tbl_FamilyCondiction_ibfk_1');
			$table->dropForeign('tbl_FamilyCondiction_ibfk_2');
		});
	}

}
