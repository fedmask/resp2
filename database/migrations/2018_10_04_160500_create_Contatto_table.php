<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContattoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Contatto', function(Blueprint $table)
		{
			$table->integer('id_contatto')->unsigned()->primary();
			$table->boolean('attivo')->nullable()->default(0);
			$table->char('tipo', 15)->index('tipo');
			$table->char('nome', 30);
			$table->char('cognome', 30);
			$table->char('sesso', 10)->index('sesso');
			$table->string('indirizzo_residenza', 100);
			$table->string('telefono', 15)->nullable();
			$table->string('mail', 50)->nullable();
			$table->date('data_nascita');
			$table->date('data_inizio');
			$table->date('data_fine');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Contatto');
	}

}
