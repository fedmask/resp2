<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblLivelliConfidenzialitaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_livelli_confidenzialita', function(Blueprint $table)
		{
			$table->smallInteger('id_livello_confidenzialita')->index('fk_tbl_livelli_confidenzialita_tbl_diagnosi_idx');
			$table->string('confidenzialita_descrizione', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_livelli_confidenzialita');
	}

}
