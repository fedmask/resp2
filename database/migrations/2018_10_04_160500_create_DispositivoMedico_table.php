<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDispositivoMedicoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('DispositivoMedico', function(Blueprint $table)
		{
			$table->integer('id_dispositivo')->unsigned()->primary();
			$table->string('tipologia', 10)->index('tipologia');
			$table->string('modello', 30);
			$table->string('fabbricante', 30);
			$table->smallInteger('confidenza');
			$table->string('note')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('DispositivoMedico');
	}

}
