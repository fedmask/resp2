<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblFarmaciTipologieSomministrazioniTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_farmaci_tipologie_somm', function(Blueprint $table)
		{
			$table->string('id_farmaco_somministrazione', 5)->primary();
			$table->text('somministrazione_descrizione', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_farmaci_tipologie_somministrazioni');
	}

}
