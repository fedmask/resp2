<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConsensoCPTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Consenso_CP', function(Blueprint $table)
		{
			$table->increments('Id_Consenso_P');
			$table->integer('Id_Trattamento')->unsigned()->index('Id_Trattamento');
			$table->integer('Id_Cpp')->unsigned()->index('Id_Cpp');
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
		Schema::drop('Consenso_CP');
	}

}
