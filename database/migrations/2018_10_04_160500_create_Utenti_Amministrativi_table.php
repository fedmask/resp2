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
			$table->longText('Nome');
			$table->longText('Cognome');
			$table->string('Ruolo', 30)->index('Ruolo');
			$table->longText('Tipi_Dati_Trattati') ->nullable();
			$table->char('Sesso', 1);
			$table->date('Data_Nascita');
			$table->integer('Comune_Nascita')->unsigned()->index('Tit-Nascita_idx');
			$table->integer('Comune_Residenza')->unsigned()->index('Tit-Residenza_idx');
			$table->longText('Indirizzo');
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
