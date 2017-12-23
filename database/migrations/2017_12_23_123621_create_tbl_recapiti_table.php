<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblRecapitiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_recapiti', function(Blueprint $table)
		{
			$table->integer('id_contatto')->primary();
			$table->integer('id_utente')->unsigned()->index('fk_tbl_contatti_tbl_utenti1_idx');
			$table->integer('id_comune_residenza')->index('fk_tbl_contatti_tbl_comuni1_idx');
			$table->integer('id_comune_nascita')->index('fk_tbl_contatti_tbl_comuni2_idx');
			$table->string('contatto_telefono', 30);
			$table->string('contatto_indirizzo', 100);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_recapiti');
	}

}
