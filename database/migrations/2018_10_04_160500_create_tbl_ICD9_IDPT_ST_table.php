<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblICD9IDPTSTTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_ICD9_IDPT_ST', function(Blueprint $table)
		{
			$table->string('id_IDPT_ST', 2)->unique('tbl_icd9_idpt_st_id_idpt_st_unique');
			$table->string('descrizione_sede', 45)->nullable();
			$table->string('descrizione_tipo_intervento', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_ICD9_IDPT_ST');
	}

}
