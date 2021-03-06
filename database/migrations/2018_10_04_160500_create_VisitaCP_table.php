<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVisitaCPTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('VisitaCP', function(Blueprint $table)
		{
			$table->integer('id_visita')->unsigned()->index('id_visita');
			$table->integer('id_cpp')->unsigned()->index('id_cpp');
			$table->date('Start_Period')->nullable();
			$table->date('End_Period')->nullable();
			$table->char('tipo', 30)->nullable()->index('tipo');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('VisitaCP');
	}

}
