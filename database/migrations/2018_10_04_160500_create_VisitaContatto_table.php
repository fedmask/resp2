<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVisitaContattoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('VisitaContatto', function(Blueprint $table)
		{
			$table->integer('id_visita')->unsigned()->index('id_visita');
			$table->integer('id_contatto')->unsigned()->index('id_contatto');
			$table->date('Start_Period')->nullable();
			$table->date('End_Period')->nullable();
			$table->char('tipo', 10)->nullable()->index('tipo');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('VisitaContatto');
	}

}
