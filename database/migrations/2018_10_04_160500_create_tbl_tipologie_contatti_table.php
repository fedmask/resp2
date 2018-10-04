<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblTipologieContattiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_tipologie_contatti', function(Blueprint $table)
		{
			$table->smallInteger('id_tipologia_contatto')->index('fk_tbl_tipologie_contatti_tbl_contatti_pazienti1_idx');
			$table->string('tipologia_nome', 50)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_tipologie_contatti');
	}

}
