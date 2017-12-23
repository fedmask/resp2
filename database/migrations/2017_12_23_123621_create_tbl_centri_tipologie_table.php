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
			$table->smallInteger('id_centro_tipologia', true);
			$table->string('tipologia_nome', 60);
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
