<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblNazioniTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_nazioni', function(Blueprint $table)
		{
			$table->increments('id_nazione');
			$table->string('nazione_nominativo', 45)->nullable();
			$table->string('nazione_prefisso_telefonico', 4)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_nazioni');
	}

}
