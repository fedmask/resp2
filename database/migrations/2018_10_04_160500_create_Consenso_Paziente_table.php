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
			$table->integer('Id_Trattamento')->unsigned()->index('Id_Trattamento');
			$table->integer('Id_Paziente')->unsigned()->index('Id_Paziente');
			$table->boolean('Consenso')->default(0);
			$table->date('data_consenso');
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
