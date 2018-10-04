<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFarmaciAssuntiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('farmaci_assunti', function(Blueprint $table)
		{
			$table->string('id_farmaco', 10)->index('id_farmaco');
			$table->integer('id_paziente')->unsigned()->index('id_paziente');
			$table->string('status', 20)->index('status');
			$table->boolean('isOverTheCounter')->nullable();
			$table->string('form', 10)->index('form');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('farmaci_assunti');
	}

}
