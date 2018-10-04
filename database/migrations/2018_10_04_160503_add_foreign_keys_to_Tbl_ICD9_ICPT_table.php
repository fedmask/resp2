<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblICD9ICPTTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Tbl_ICD9_ICPT', function(Blueprint $table)
		{
			$table->foreign('IDPT_Organo')->references('id_IDPT_Organo')->on('tbl_ICD9_IDPT_Organi')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('IDPT_ST')->references('id_IDPT_ST')->on('tbl_ICD9_IDPT_ST')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('Tbl_ICD9_ICPT', function(Blueprint $table)
		{
			$table->dropForeign('tbl_icd9_icpt_idpt_organo_foreign');
			$table->dropForeign('tbl_icd9_icpt_idpt_st_foreign');
		});
	}

}
