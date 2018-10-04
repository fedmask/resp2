<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblCppPersonaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_cpp_persona', function(Blueprint $table)
		{
			$table->increments('id_persona');
			$table->integer('id_utente')->unsigned()->index('id_utente');
			$table->integer('id_comune')->unsigned()->index('fk_tbl_cpp_persona_tbl_comuni1_idx');
			$table->string('persona_nome', 45)->nullable();
			$table->string('persona_cognome', 45)->nullable();
			$table->string('persona_telefono', 45)->nullable();
			$table->string('persona_fax', 45)->nullable();
			$table->string('persona_reperibilita', 45)->nullable();
			$table->boolean('persona_attivo');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_cpp_persona');
	}

}
