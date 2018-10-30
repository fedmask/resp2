<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttivitaAmministrativeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Attivita_Amministrative', function(Blueprint $table)
		{
			$table->integer('id_attivita')->autoIncrement();
			$table->integer('id_utente')->unsigned();
			$table->date('Start_Period');
			$table->date('End_Period')->nullable();
			$table->longText('Tipologia_attivita');
			$table->longText('Descrizione')->nullable();
			$table->longText('Anomalie_riscontrate')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Attivita_Amministrative');
	}

}
