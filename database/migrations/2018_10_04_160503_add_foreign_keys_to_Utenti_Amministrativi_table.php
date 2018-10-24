<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUtentiAmministrativiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Utenti_Amministrativi', function(Blueprint $table)
		{
			$table->foreign('id_utente', 'Tit-Audit')->references('id_utente')->on('tbl_utenti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('Comune_Nascita', 'Tit-Nascita')->references('id_comune')->on('tbl_comuni')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('Comune_Residenza', 'Tit-Residenza')->references('id_comune')->on('tbl_comuni')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('Ruolo', 'Utenti_Amministrativi_ibfk_1')->references('Ruolo')->on('Ruoli_amministratori')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('Utenti_Amministrativi', function(Blueprint $table)
		{
			$table->dropForeign('Tit-Audit');
			$table->dropForeign('Tit-Nascita');
			$table->dropForeign('Tit-Residenza');
			$table->dropForeign('Utenti_Amministrativi_ibfk_1');
			});
	}

}
