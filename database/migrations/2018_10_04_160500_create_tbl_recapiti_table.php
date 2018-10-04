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
			$table->increments('id_contatto');
			$table->integer('id_utente')->unsigned()->index('id_utente');
			$table->integer('id_comune_residenza')->unsigned()->index('id_comune_residenza');
			$table->integer('id_comune_nascita')->unsigned()->nullable();
			$table->string('contatto_telefono', 30)->nullable();
			$table->string('contatto_indirizzo', 100)->nullable();
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
