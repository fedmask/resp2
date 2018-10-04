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
			$table->increments('id_vaccino');
			$table->integer('id_vaccinazione')->unsigned()->index('fk_tbl_vaccino_tbl_vaccinazione1_idx');
			$table->string('vaccino_codice', 7)->nullable();
			$table->text('vaccino_descrizione', 65535)->nullable();
			$table->text('vaccino_nome', 65535)->nullable();
			$table->integer('vaccino_durata');
			$table->string('vaccino_manufactured', 45)->nullable();
			$table->date('vaccino_expirationDate');
			$table->char('Codice_ATC', 7)->nullable()->index('Codice_ATC');
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
