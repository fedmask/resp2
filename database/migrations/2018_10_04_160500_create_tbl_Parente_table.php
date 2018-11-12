<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblParenteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_Parente', function(Blueprint $table)
		{
			$table->increments('id_parente');
			$table->integer('id_paziente');
			$table->char('codice_fiscale', 16)->nullable();
<<<<<<< HEAD
			$table->string('nome', 25)->nullable();
			$table->string('cognome', 25)->nullable();
            $table->string('grado_parentela', 25)->nullable();
			$table->string('sesso', 8)->nullable();
			$table->date('data_nascita');
			$table->integer('età');
            $table->text('annotazioni')->nullable();
			$table->boolean('decesso');
			$table->integer('età_decesso');
			$table->date('data_decesso')->nullable();
=======
			$table->string('nome', 25);
			$table->string('cognome', 25);
			$table->string('sesso', 10)->index('sesso');
			$table->string('telefono', 11);
			$table->string('mail', 150);
			$table->date('data_nascita');
			$table->integer('eta');
			$table->boolean('decesso');
			$table->integer('eta_decesso');
			$table->date('data_decesso');
		
			$table->foreign('sesso', 'tbl_Parente_ibfk_1')->references('Code')->on('Gender')->onUpdate('NO ACTION')->onDelete('NO ACTION');
>>>>>>> PennellaRESP
		});
		
		
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_Parente');
	}

}
