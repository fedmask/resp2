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
			$table->smallInteger('id_livello_confidenzialita')->primary();
			$table->string('confidenzialita_codice', 45);
			$table->string('confidenzialita_descrizione', 45);
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
