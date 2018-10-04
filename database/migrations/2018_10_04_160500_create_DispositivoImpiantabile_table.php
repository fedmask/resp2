<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDispositivoImpiantabileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('DispositivoImpiantabile', function(Blueprint $table)
		{
			$table->increments('id_dis');
			$table->integer('id_dispositivo')->unsigned()->index('id_dispositivo');
			$table->integer('id_paziente')->unsigned()->index('id_paziente');
			$table->integer('id_cpp')->unsigned()->index('id_cpp');
			$table->string('stato', 20)->index('stato');
			$table->date('data_impianto');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('DispositivoImpiantabile');
	}

}
