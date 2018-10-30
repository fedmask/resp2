<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblCentriTipologieTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_centri_tipologie', function(Blueprint $table)
		{
			$table->smallInteger('id_centro_tipologia')->index('fk_tbl_cpp_persona_tbl_centri_indagini1_idx');
			$table->longText('tipologia_nome')->nullable();
			$table->char('code_fhir', 6)->nullable()->default('other')->index('code_fhir');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_centri_tipologie');
	}

}
