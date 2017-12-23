<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblVacciniTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_vaccini', function(Blueprint $table)
		{
			$table->integer('id_vaccino', true);
			$table->string('vaccino_codice', 7);
			$table->text('vaccino_descrizione', 65535);
			$table->text('vaccino_nome', 65535);
			$table->integer('vaccino_durata');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_vaccini');
	}

}
