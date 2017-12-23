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
	    if (!Schema::hasTable('tbl_utenti')) {

    		Schema::create('tbl_utenti', function(Blueprint $table)
    		{
    			$table->integer('id_utente', true);
    			$table->boolean('id_ruolo')->index('fk_tbl_utenti_ruoli_idx');
    			$table->string('utente_nome', 50);
    			$table->string('utente_password', 130);
    			$table->boolean('utente_stato');
    			$table->date('utente_scadenza');
    			$table->string('utente_email', 100)->unique('utente_email_UNIQUE');
    			$table->string('utente_token_accesso', 60)->nullable();
    		});
	    }
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
