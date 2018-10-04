<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDocumentiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Documenti', function(Blueprint $table)
		{
			$table->foreign('Id_Amministratore', 'Documenti_ibfk_1')->references('id_utente')->on('Utenti_Amministrativi')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('Documenti', function(Blueprint $table)
		{
			$table->dropForeign('Documenti_ibfk_1');
		});
	}

}
