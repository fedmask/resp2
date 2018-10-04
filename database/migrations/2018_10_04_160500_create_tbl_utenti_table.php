<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblUtentiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_utenti', function(Blueprint $table)
		{
			$table->increments('id_utente');
			$table->char('id_tipologia', 3)->nullable()->index('fk_tbl_utenti_ruoli_idx');
			$table->string('utente_nome', 50)->nullable();
			$table->string('utente_password', 130)->nullable();
			$table->boolean('utente_stato');
			$table->date('utente_scadenza');
			$table->string('utente_email', 100)->nullable()->unique('utente_email_UNIQUE');
			$table->string('utente_token_accesso', 60)->nullable();
			$table->boolean('utente_dati_condivisione')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_utenti');
	}

}
