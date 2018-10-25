<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUtentiAmministrativiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Utenti_Amministrativi', function(Blueprint $table)
		{
			$table->integer('id_utente')->unsigned()->index('Tit-Audit');
			$table->string('Nome');
			$table->string('Cognome');
			$table->string('Ruolo', 30)->index('Ruolo');
			$table->string('Tipi_Dati_Trattati', 45) ->nullable();
			$table->char('Sesso', 1);
			$table->date('Data_Nascita');
			$table->integer('Comune_Nascita')->unsigned()->index('Tit-Nascita_idx');
			$table->integer('Comune_Residenza')->unsigned()->index('Tit-Residenza_idx');
			$table->string('Indirizzo', 45);
			$table->integer('Recapito_Telefonico');
		});
	}

	
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Utenti_Amministrativi');
	}

}
