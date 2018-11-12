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
			$table->integer('id_paziente')->unsigned()->index('id_paziente');
			$table->boolean('attivo')->nullable()->default(0);
			$table->char('relazione', 10)->index('relazione');
			$table->char('nome', 30);
			$table->char('cognome', 30);
			$table->char('sesso', 10)->index('sesso');
			$table->string('telefono', 15)->nullable();
			$table->string('mail', 50)->nullable();
			$table->date('data_nascita');
			$table->date('data_inizio')->nullable();
			$table->date('data_fine')->nullable();
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
