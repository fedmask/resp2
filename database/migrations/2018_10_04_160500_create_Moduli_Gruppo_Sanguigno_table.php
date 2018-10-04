<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModuliGruppoSanguignoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Moduli_Gruppo_Sanguigno', function(Blueprint $table)
		{
			$table->integer('Id_Modulo')->unsigned()->primary();
			$table->integer('Id_Paziente')->unsigned()->index('Id_Paziente');
			$table->binary('documento');
			$table->date('data_caricamento');
			$table->date('data_convalida')->nullable();
			$table->string('note')->nullable();
			$table->boolean('Stato')->default(0);
			$table->integer('Id_Amministratore')->unsigned()->nullable()->index('Id_Amministratore');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Moduli_Gruppo_Sanguigno');
	}

}
