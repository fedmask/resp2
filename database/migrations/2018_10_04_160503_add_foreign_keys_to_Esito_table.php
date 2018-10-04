<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEsitoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Esito', function(Blueprint $table)
		{
			$table->foreign('id_visita', 'Esito_ibfk_1')->references('id_visita')->on('tbl_pazienti_visite')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('Code', 'Esito_ibfk_2')->references('Code')->on('EncounterReason')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('Esito', function(Blueprint $table)
		{
			$table->dropForeign('Esito_ibfk_1');
			$table->dropForeign('Esito_ibfk_2');
		});
	}

}
