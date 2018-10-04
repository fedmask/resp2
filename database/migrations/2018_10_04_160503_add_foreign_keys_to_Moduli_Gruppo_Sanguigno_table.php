<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToModuliGruppoSanguignoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Moduli_Gruppo_Sanguigno', function(Blueprint $table)
		{
			$table->foreign('Id_Amministratore', 'Moduli_Gruppo_Sanguigno_ibfk_1')->references('id_utente')->on('Utenti_Amministrativi')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('Id_Paziente', 'Moduli_Gruppo_Sanguigno_ibfk_2')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('Moduli_Gruppo_Sanguigno', function(Blueprint $table)
		{
			$table->dropForeign('Moduli_Gruppo_Sanguigno_ibfk_1');
			$table->dropForeign('Moduli_Gruppo_Sanguigno_ibfk_2');
		});
	}

}
