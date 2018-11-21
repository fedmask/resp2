<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAttivitaAmministrativeTable extends Migration {
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Attivita_Amministrative', function(Blueprint $table)
		{
			$table->foreign('id_utente','A_amm_ibfk_1')->references('id_utente')->on('Utenti_Amministrativi')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}
	
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('Attivita_Amministrative', function(Blueprint $table)
		{
			$table->dropForeign('A_amm_ibfk_1');
		});
	}
	
}
