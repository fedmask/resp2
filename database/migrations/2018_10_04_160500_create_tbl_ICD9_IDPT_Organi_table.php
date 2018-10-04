<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblICD9IDPTOrganiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_ICD9_IDPT_Organi', function(Blueprint $table)
		{
			$table->char('id_IDPT_Organo', 2)->unique('tbl_icd9_idpt_organi_id_idpt_organo_unique');
			$table->string('descrizione', 20)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_ICD9_IDPT_Organi');
	}

}
