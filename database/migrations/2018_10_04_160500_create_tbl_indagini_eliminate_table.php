<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblIndaginiEliminateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_indagini_eliminate', function(Blueprint $table)
		{
			$table->increments('id_indagine_eliminata');
			$table->integer('id_utente')->unsigned()->index('fk_tbl_indagini_eliminate_tbl_utenti1_idx');
			$table->integer('id_indagine')->unsigned()->index('fk_tbl_indagini_eliminate_tbl_indagini1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_indagini_eliminate');
	}

}
