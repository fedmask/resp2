<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblICD9ICPTTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Tbl_ICD9_ICPT', function(Blueprint $table)
		{
			$table->string('Codice_ICD9', 5)->unique('tbl_icd9_icpt_codice_icd9_unique');
			$table->char('IDPT_Organo', 2)->nullable()->index('tbl_icd9_icpt_idpt_organo_foreign');
			$table->string('IDPT_ST', 2)->nullable()->index('tbl_icd9_icpt_idpt_st_foreign');
			$table->string('Descizione_ICD9', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Tbl_ICD9_ICPT');
	}

}
