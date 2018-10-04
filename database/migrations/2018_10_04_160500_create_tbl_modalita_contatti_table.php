<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblModalitaContattiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_modalita_contatti', function(Blueprint $table)
		{
			$table->smallInteger('id_modalita')->index('fk_tbl_centri_indagini_tbl_centri_contatti1_idx');
			$table->string('modalita_nome', 50)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_modalita_contatti');
	}

}
