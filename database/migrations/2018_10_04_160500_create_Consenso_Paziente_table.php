<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConsensoPazienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Consenso_Paziente', function(Blueprint $table)
		{
			$table->increments('Id_Consenso_P');
			$table->integer('Id_Trattamento')->unsigned();
			$table->integer('Id_Paziente')->unsigned();
			$table->boolean('Consenso')->default(0);
			$table->dateTime('data_consenso');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Consenso_Paziente');
	}

}
