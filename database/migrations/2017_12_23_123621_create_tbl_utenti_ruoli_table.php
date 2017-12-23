<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblUtentiRuoliTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_utenti_ruoli', function(Blueprint $table)
		{
			$table->boolean('id_ruolo')->primary();
			$table->string('ruolo_nome', 20);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_utenti_ruoli');
	}

}
