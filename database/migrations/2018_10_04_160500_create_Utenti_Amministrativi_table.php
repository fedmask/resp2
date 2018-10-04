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
			$table->string('Ruolo', 45)->index('Ruolo');
			$table->string('Tipi_Dati_Trattati', 45);
			$table->string('Nome', 45);
			$table->string('Cognome', 45);
			$table->char('Sesso', 1);
			$table->string('Codice_Fiscale', 16);
			$table->date('Data_Nascita');
			$table->integer('Comune_Nascita')->unsigned()->index('Tit-Nascita_idx');
			$table->integer('Comune_Residenza')->unsigned()->index('Tit-Residenza_idx');
			$table->string('Indirizzo', 45);
			$table->integer('Recapito_Telefonico');
			$table->char('Stato_Civile', 3)->index('Stato_Civile');
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
