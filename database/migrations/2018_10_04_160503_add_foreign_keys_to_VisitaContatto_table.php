<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToVisitaContattoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('VisitaContatto', function(Blueprint $table)
		{
			$table->foreign('id_contatto', 'VisitaContatto_ibfk_1')->references('id_contatto')->on('Contatto')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_visita', 'VisitaContatto_ibfk_2')->references('id_visita')->on('tbl_pazienti_visite')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('tipo', 'VisitaContatto_ibfk_3')->references('Code')->on('EncounterParticipantType')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('VisitaContatto', function(Blueprint $table)
		{
			$table->dropForeign('VisitaContatto_ibfk_1');
			$table->dropForeign('VisitaContatto_ibfk_2');
			$table->dropForeign('VisitaContatto_ibfk_3');
		});
	}

}
