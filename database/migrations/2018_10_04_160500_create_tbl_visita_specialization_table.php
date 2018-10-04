<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblVisitaSpecializationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_visita_specialization', function(Blueprint $table)
		{
			$table->increments('id_vs');
			$table->integer('id_visita')->unsigned()->index('id_visita');
			$table->integer('id_specialization')->unsigned()->index('FOREIGN_Specialization_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_visita_specialization');
	}

}
