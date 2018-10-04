<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblDiagnosiEliminateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_diagnosi_eliminate', function(Blueprint $table)
		{
			$table->increments('id_diagnosi_eliminata');
			$table->integer('id_utente')->unsigned()->index('fk_tbl_diagnosi_eliminate_tbl_pazienti1_idx');
			$table->integer('id_diagnosi')->unsigned()->index('fk_tbl_diagnosi_eliminate_tbl_diagnosi1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_diagnosi_eliminate');
	}

}
